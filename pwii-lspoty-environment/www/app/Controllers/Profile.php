<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    /**
     * Muestra el perfil del usuario
     */
    public function index()
    {
        // Obtener el ID del usuario de la sesión
        $user     = session()->get('user');
        $userId = $user['id'];

        $user = $this->userModel->findUserById($userId);

        $data = [
            'title' => 'Mi Perfil',
            'user' => $user
        ];

        return view('profile/index', $data);
    }

    /**
     * Editar perfil
     */
    public function edit()
    {
        $user     = session()->get('user');
        $userId = $user['id'];


        $user = $this->userModel->findUserById($userId);

        $data = [
            'title' => 'Editar Perfil',
            'user' => $user
        ];

        return view('profile/edit', $data);
    }

    /**
     * Actualizar perfil
     */
    public function update()
    {
        $user = session()->get('user');
        $userId = $user['id'];

        $rules = [
            'username' => [
                'permit_empty',
                'alpha_numeric_space',
                'min_length[3]',
                'max_length[30]'
            ],
            'new_password' => [
                'permit_empty',
                'min_length[8]',
                'check_password_strength',
                'required_with[current_password]' // Obligatorio si hay current_password
            ],
            'repeat_password' => [
                'permit_empty',
                'matches[new_password]',
                'required_with[new_password]' // Obligatorio si hay new_password
            ],
            'age' => [
                'permit_empty',
                'numeric',
                'greater_than_equal_to[1]', // Edad mínima 1
                'less_than_equal_to[120]'    // Edad máxima razonable
            ],
            'profile_pic' => [
                'permit_empty',
                'uploaded[profile_pic]',
                'max_size[profile_pic,2048]', // 2MB máximo
                'is_image[profile_pic]',
                'ext_in[profile_pic,jpg,jpeg,png]',
                'mime_in[profile_pic,image/jpg,image/jpeg,image/png]'
            ]
        ];

        // Definición de mensajes de error
        $validationMessageErrors = [
            'username' => [
                'alpha_numeric_space' => lang('app.errUsernameType'),
            ],
            'new_password' => [
                'min_length' => lang('app.errPassLength'),
                'check_password_strength' => lang('app.errPassStrength'),
            ],
            'repeat_password' => [
                'matches' => lang('app.errPassMatch'),
            ],
            'age' => [
                'numeric' => lang('App.errAgeNumeric'),
                'greater_than_equal_to' => lang('App.errAgeMin'),
                'less_than_equal_to' => lang('App.errAgeMax')
            ],
        ];

        if (!$this->validate($rules, $validationMessageErrors)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Preparar datos para actualización
        $data = [
            'username' => $this->request->getPost('username')
        ];

        $age = $this->request->getPost('age');
        if (is_numeric($age)) {
            $data['age'] = (int) $age;
        }

        // Manejar cambio de contraseña si se proporcionó
        if ($this->request->getPost('new_password')) {
            $data['password'] = $this->request->getPost('new_password');
        }

        // Manejar la carga de la imagen de perfil
        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic->isValid() && !$profilePic->hasMoved()) {
            $newName = $profilePic->getRandomName();
            $profilePic->move(ROOTPATH . 'public/uploads/profile_pics', $newName);
            $data['profile_pic'] = 'uploads/profile_pics/' . $newName;

            // Eliminar imagen anterior si existe
            $oldImage = $this->userModel->findUserById($userId)['profile_pic'];
            if ($oldImage && file_exists(ROOTPATH . 'public/' . $oldImage)) {
                unlink(ROOTPATH . 'public/' . $oldImage);
            }
        }

        // Actualizar usuario
        if ($this->userModel->updateUser($userId, $data)) {
            // Actualizar datos en sesión si es necesario
            $updatedUser = $this->userModel->findUserById($userId);
            session()->set('user', $updatedUser);

            return redirect()->to('/profile')->with('success', lang('app.profileUpdateSuccess'));
        } else {
            return redirect()->back()->withInput()->with('error', lang('app.profileUpdateError'));
        }
    }
}