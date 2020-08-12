<?php

namespace Credit\Http\Requests\Client;

use Credit\Http\Requests\Request;

class ClientCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'min:3',
            'email' => 'unique:clients,email',
            'id_document' => 'unique:clients,id_document',
        ];
    }

    public function messages()
    {
        return [
            'name.not_in' => 'Nombre o Razón Social debe tener al menos 3 caracteres',
            'email.not_in' => 'Correo electrónico ya ha sido registrado anteriormente',
            'id_document.not_in' => 'CI o NIT ya ha sido registrado anteriormente',
        ];
    }
}
