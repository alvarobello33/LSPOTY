<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Authentication extends BaseController{

    //Mostrem el form del login
    public function signIn(): string{
        helper(['form']);
        return view('sign-in');
    }

    //Mostrem el form de registre
    public function signUp(): string{
        helper(['form']);
        return view('sign-up');
    }

    //Funció per controlar el registre
    public function register(){

        helper(['form', 'filesystem']);

        //Definim les rules de validació
        $validationRules = [
            'username'          => 'permit_empty|alpha_numeric_space',
            'profile_picture'  => 'permit_empty|max_size[profile_picture,2048]|is_image[profile_picture]|ext_in[profile_picture,jpg,jpeg]|mime_in[profile_picture,image/jpeg,image/jpg]',
            'email'             => 'required|valid_email|is_unique[users.email]|check_email_domain',
            'password'          => 'required|min_length[8]|check_password_strength',
            'repeat_password'   => 'required|matches[password]',
        ];

        //Definim els missatges d'error
        $validationMessageErrors = [
            'username' => [
                'alpha_numeric_space' => lang('app.errUsernameType'),
            ],
            'email' => [
                'required'    => lang('app.errEmailRequired'),
                'valid_email' => lang('app.errEmailValid'),
                'is_unique'    => lang('app.errEmailUnique'),
                'check_email_domain' => lang('app.errEmailDomain'),
            ],
            'password' => [
                'required'   => lang('app.errPassRequired'),
                'min_length' => lang('app.errPassLength'),
                'check_password_strength' => lang('app.errPassStrength'),
            ],
            'repeat_password' => [
                'required'   => lang('app.errPassRequired'),
                'matches'    => lang('app.errPassMatch'),
            ]
        ];

        //Si no compleix la validació retornem a la vista
        if (!$this->validate($validationRules, $validationMessageErrors)) {
            return view('sign-up', [
                'validation' => $this->validator,
                //Guardem a old els valors antics per reescriure'ls
                'old' => $this->request->getPost(),
            ]);
        }

        //Si passa la validació

        //GEstionem el username
        $email    = $this->request->getPost('email');
        $username = $this->request->getPost('username') ?: explode('@', $email)[0];

        // Manejar la carga de la imagen de perfil
        $profilePic_url = '';
        $profilePic = $this->request->getFile('profile_pic');
        if ($profilePic->isValid() && !$profilePic->hasMoved()) {
            $newName = $profilePic->getRandomName();
            $profilePic->move(ROOTPATH . 'public/uploads/profile_pics', $newName);
            $profilePic_url = 'uploads/profile_pics/' . $newName;

        }

        //Creem usuari i redirigim

        $userModel = new \App\Models\UserModel();

        $userModel->save([
            'username' => $username,
            'email' => $email,
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'profile_pic' => $profilePic_url,
        ]);

        //Flash Message de Registre amb èxit
        session()->setFlashdata('success', lang('app.fmRegisterSuccess'));

        //Redirigim
        return redirect()->to(route_to('sign-in-view'));

    }

    //Funció per controlar el login
    public function login(){

        helper(['form']);

        $validationRules = [
            'email'    => 'required|valid_email|check_email_domain',
            'password' => 'required|min_length[8]|check_password_strength',
        ];

        $validationMessageErrors = [
            'email' => [
                'required'    => lang('app.errEmailRequired'),
                'valid_email' => lang('app.errEmailValid'),
                'check_email_domain' => lang('app.errEmailDomain'),
            ],
            'password' => [
                'required'   => lang('app.errPassRequired'),
                'min_length' => lang('app.errPassLength'),
                'check_password_strength' => lang('app.errPassStrength'),
            ]
        ];

        //Si no compleix la validació retornem a la vista
        if (!$this->validate($validationRules, $validationMessageErrors)) {
            return view('sign-in', [
                'validation' => $this->validator,
                //Guardem a old els valors antics per reescriure'ls
                'old' => $this->request->getPost(),
            ]);
        }

        //Obtenim les credencials del form
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        $userModel = new \App\Models\UserModel();

        //Busquem el mail a la bbdd
        $user = $userModel->where('email', $email)->first();

        //Si no es troba un usuari amb el mateix email registrat previament
        if (!$user) {
            return view('sign-in', [
                'validation' => $this->validator,
                'old' => $this->request->getPost(),
                'error' => lang('app.errEmailNotExist'),
            ]);
        }

        //Si la contrasenya no és correcte
        if (!password_verify($password, $user['password'])) {
            return view('sign-in', [
                'validation' => $this->validator,
                'error' => lang('app.errPassIncorrect'),
            ]);
        }

        //Si està tot bé, fem el login i guardem l'usuari a la sessió
        session()->set('user', [
            'id' => $user['id'],
            'email' => $user['email'],
            'username' => $user['username'],
        ]);

        //Redirigim a la homepage
        return redirect()->to(route_to('home-view'));

    }

    //Funció per controlar el logout
    public function logout(){

        //Esborrem la sessió de l'usuari
        session()->destroy();

        //Redirigim a la landing page
        return redirect()->to(route_to('landing-page-view'));
    }


}
