<?php
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Operador.php';
require_once __DIR__ . '/../models/Administrador.php';

class AdministradorController
{
    private $db;
    private $administrador;
    private $usuarios;


    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->administrador = new Administrador($this->db);
        $this->usuarios = new Usuario($this->db);

        $this->administrador->id = $_SESSION['administrador_id'] ?? null;
    }


    public function getUsers(): void
    {
        $rol = strtolower(filter_input(INPUT_GET, 'rol', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? '');
        $email = filter_input(INPUT_GET, 'email', FILTER_SANITIZE_EMAIL) ?? '';
    
        if (empty($this->administrador->id)) {
            $error = 'Access denied. Administrator not logged in.';
            require_once __DIR__ . '/../views/administrar-usuarios.php';
            return;
        }
    
        $rolesMap = [
            'operador' => 'operadores',
            'gerente' => 'gerentes',
            'cliente' => 'clientes'
        ];
    
        $roleKey = $rolesMap[$rol] ?? '';
    
        if ($roleKey) {
            $usuarios = $this->administrador->obtenerUsuarios($roleKey, $email);
        }else{
            $usuarios = [];
        }

    
        require_once __DIR__ . '/../views/administrar-usuarios.php';
    }
    


    public function GuardarCambios() {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $codigo_empleado = $_POST['codigo_empleado'];
        $extension_tel = $_POST['extension_tel'];
        $estado = $_POST['status'];
        $rol = $_POST['rol'];
        $correo = $_POST['correo'];
        $dui = $_POST['rol'];
        $telefono = $_POST['correo'];
    
            $this->administrador->updateUsuario($id, $nombre, $estado, $rol, $correo);
    
        if ($rol == 'cliente') {
            $this->administrador->saveCliente($id, $nombre, $apellido, $estado, $dui, $telefono);
        } else {
            $table = ($rol == 'gerente') ? 'gerentes' : 'operadores';
    
            $this->administrador->saveGerenteOOperador(
                $table,
                $id,
                $nombre,
                $apellido,
                $codigo_empleado,
                $extension_tel,
                $estado
            );
        }
    
        require_once __DIR__ . '/../views/administrar-usuarios.php';

    }
    




}

