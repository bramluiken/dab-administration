<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Error;
use App\Factories\FormFactory;

class FormController extends BaseController {

    public function handle($request) {
        $formFactory = $this->container->get(FormFactory::class);

        $formName = $request['params']['form'];
        try {
            $form = $formFactory->create($formName, ['', '', $formName, ]);
        } catch (Error $err) {
            return false;
        }

        // Check the HTTP method to determine whether to render or process submission.
        $method = strtoupper($request['method'] ?? 'GET');

        if ($method !== 'POST') {
            // Display the form if not a POST request.
            echo $form->render();
            return;
        }

        // Process the submitted form data (POST).
        $data = $request['data'] ?? [];
        $result = $form->handle($data);

        if ($result) {
            echo "Form data processed successfully.";
        } else {
            echo $form->render();
        }
        
    }
}