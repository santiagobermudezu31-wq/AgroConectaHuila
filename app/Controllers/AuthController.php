<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\Response;
use App\Helpers\Security;
use App\Helpers\Validator;
use App\Models\Producer;
use App\Models\User;

class AuthController extends Controller
{
    public function showRegister(): void
    {
        $this->view('auth/register', [], 'auth');
    }

    public function showLogin(): void
    {
        $this->view('auth/login', [], 'auth');
    }

    public function register(): void
    {
        $in = $this->input();
        $u  = trim($in['nombre_usuario'] ?? '');
        $e  = trim($in['correo'] ?? '');
        $p  = $in['password'] ?? '';
        $pc = $in['password_confirmacion'] ?? '';
        $np = trim($in['nombre_productor'] ?? '');
        $nu = trim($in['nombre_unidad_productiva'] ?? '');
        $z  = trim($in['zona_vereda'] ?? '');
        $m  = trim($in['municipio'] ?? 'La Plata');
        $d  = trim($in['departamento'] ?? 'Huila');
        $t  = trim($in['telefono_comercial'] ?? '');
        $acc= (bool)($in['acepta_politica'] ?? false);

        $errs = [];
        if ($u === '')  $errs['nombre_usuario'] = 'Requerido.';
        if (!Validator::email($e)) $errs['correo'] = 'Formato inválido.';
        if (strlen($p) < 8) $errs['password'] = 'Mínimo 8 caracteres.';
        if ($p !== $pc)     $errs['password_confirmacion'] = 'No coinciden.';
        if ($np === '')     $errs['nombre_productor'] = 'Requerido.';
        if ($z === '')      $errs['zona_vereda'] = 'Requerido.';
        if (!$acc)          $errs['acepta_politica'] = 'Debe aceptar.';
        if ($t !== '' && !Validator::phone($t)) $errs['telefono_comercial'] = 'Formato inválido.';

        if ($errs) {
            Response::error('Datos inválidos', 422, $errs);
        }

        $users = new User();
        if ($users->exists($u, $e)) {
            Response::error('Usuario o correo ya registrado.', 422);
        }

        $pdo = \Database::connection();
        try {
            $pdo->beginTransaction();
            $uid = $users->create([
                'nombre_usuario' => $u,
                'correo'         => $e,
                'password'       => $p,
                'rol'            => 'productor',
            ]);
            (new Producer())->create([
                'usuario_id'              => $uid,
                'nombre_productor'        => $np,
                'nombre_unidad_productiva'=> $nu,
                'zona_vereda'             => $z,
                'municipio'               => $m,
                'departamento'            => $d,
                'telefono_comercial'      => $t,
                'mostrar_telefono'        => 1,
            ]);
            $pdo->prepare(
                'INSERT INTO aceptacion_politicas (usuario_id,tipo_politica,version_politica)
                 VALUES (?, "tratamiento_datos", "1.0")'
            )->execute([$uid]);

            $pdo->commit();
            Response::success('Registro creado correctamente.', ['usuario_id' => $uid], 201);
        } catch (\Throwable $ex) {
            $pdo->rollBack();
            Response::error('Error al registrar: ' . $ex->getMessage(), 500);
        }
    }

    public function login(): void
    {
        if (Security::rateLimited('login')) {
            Response::error('Demasiados intentos. Intente más tarde.', 429);
        }

        $in = $this->input();
        $ident = trim($in['identificador'] ?? '');
        $pass  = $in['password'] ?? '';

        if ($ident === '' || $pass === '') {
            Response::error('Datos incompletos.', 422);
        }

        $u = (new User())->findByLogin($ident);

        if (!$u || !password_verify($pass, $u['password_hash'])) {
            Response::error('Credenciales inválidas.', 401);
        }
        if ($u['estado'] !== 'activo') {
            Response::error('Cuenta no activa.', 403);
        }

        session_regenerate_id(true);
        $_SESSION['usuario_id'] = (int)$u['id'];
        $_SESSION['rol']        = $u['rol'];
        $_SESSION['usuario']    = $u['nombre_usuario'];

        Response::success('Sesión iniciada.', [
            'usuario' => [
                'id'     => (int)$u['id'],
                'rol'    => $u['rol'],
                'nombre' => $u['nombre_usuario'],
            ],
        ]);
    }

    public function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
        $this->redirect('/');
    }
}