<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\User;
use Sirius\Validation\Validator;

class RegisterController extends BaseController {

    /**
     * Ruta [GET] /registro que muestra el formulario de registro.
     *
     * @return string Render de la web con toda la información.
     */
    public function getRegister(){
        return $this->render('auth/register.twig',[]);
    }

    /**
     * Ruta [POST] /registro que processa los datos de registro.
     *
     * @return string Render de la web con toda la información.
     */
    public function postRegister(){
        $errors = [];
        $validator = new Validator();

        $validator->add('inputName:Nombre', 'required', [], 'El {label} es obligatorio');
        $validator->add('inputName:Nombre', 'minlength', ['min' => 5], 'El {label} debe tener al menos 5 caracteres');
        $validator->add('inputEmail:Email', 'required', [], 'El {label} es obligatorio');
        $validator->add('inputEmail:Email', 'email', [], 'No es un email válido');
        $validator->add('inputPassword1:Password', 'required', [], 'La {label} es requerida');
        $validator->add('inputPassword1:Password', 'minlength', ['min' => 8], 'La {label} debe tener al menos 8 caracteres');
        $validator->add('inputPassword2:Password', 'required', [], 'La {label} es requerida');
        $validator->add('inputPassword2:Password', 'match', 'inputPassword1', 'Las passwords deben coincidir');

        if($validator->validate($_POST)){
            $user = new User();

            $user->name = $_POST['inputName'];
            $user->email = $_POST['inputEmail'];
            $user->password = password_hash($_POST['inputPassword1'], PASSWORD_DEFAULT);

            $user->save();

            header('Location: '.BASE_URL);
        }else{
            $errors = $validator->getMessages();
        }

        return $this->render('auth/register.twig', ['errors' => $errors]);
    }
}