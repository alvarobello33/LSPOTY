<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['email', 'password', 'username', 'profile_pic', 'age', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $dateFormat    = 'datetime';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    /**
     * Agrega un nuevo usuario a la base de datos
     *
     * @param array $data Datos del usuario
     * @return int|false ID del nuevo usuario o false en caso de error
     */
    public function addUser(array $data)
    {
        // Hashear la contraseña antes de guardarla
        if (isset($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Establecer la fecha de creación
        $data['created_at'] = date('Y-m-d H:i:s');

        try {
            return $this->insert($data);
        } catch (\Exception $e) {
            log_message('error', 'Error al agregar usuario: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Actualiza los datos de un usuario, incluyendo contraseña opcional
     *
     * @param int $userId ID del usuario a actualizar
     * @param array $data Datos a actualizar
     * @return bool True si la actualización fue exitosa, false en caso contrario
     */
    public function updateUser(int $userId, array $data): bool
    {
        try {
            // Hashear la nueva contraseña si se proporciona
            if (!empty($data['password'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            } else {
                // Eliminar la clave password si está vacía para no actualizarla
                unset($data['password']);
            }

            // Actualizar el usuario
            $result = $this->update($userId, $data);

            // Verificar si realmente se actualizó algún registro
            if ($result === false) {
                log_message('error', 'Error al actualizar usuario: No se afectaron filas');
                return false;
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Error al actualizar usuario: ' . $e->getMessage());
            return false;
        }
    }


    /**
     * Busca un usuario por su id
     *
     * @param string $id ID del usuario a buscar
     * @return array|null Datos del usuario o null si no se encuentra
     */
    public function findUserById(string $id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Busca un usuario por su email
     *
     * @param string $email Email del usuario a buscar
     * @return array|null Datos del usuario o null si no se encuentra
     */
    public function findUserByEmail(string $email)
    {
        return $this->where('email', $email)->first();
    }

    /**
     * Verifica si un email ya está registrado
     *
     * @param string $email Email a verificar
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        return $this->where('email', $email)->countAllResults() > 0;
    }
}