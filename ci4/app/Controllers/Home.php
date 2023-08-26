<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }

    public function contactForm(): string
    {
        return view("contactForm/contact_form");
    }

    public function manageContactFormData()
    {
        $nume              = $this->request->getPost('nume');
        $prenume        = $this->request->getPost('prenume');
        $telefon           = $this->request->getPost('telefon');
        $email              = $this->request->getPost('email');
        $mesaj             = $this->request->getPost('mesaj') ?? null;

        $errors = [];

        if (empty($nume)) {
            $errors['nume'] = 'Campul Nume trebuie completat!';
        }

        if (empty($prenume)) {
            $errors['prenume'] = 'Campul Prenume trebuie completat!';
        }

        if (empty($telefon)) {
            $errors['telefon'] = 'Campul Telefon trebuie completat!';
        }

        if (empty($email)) {
            $errors['email'] = 'Campul Email trebuie completat!';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Format invalid Email!';
        }

        if (!empty($errors)) {
            return $this->response->setStatusCode(500)->setJson(['errors'=>$errors]);
        }

        $clientiModel = model("ClientiModel");

        $existingClient = $clientiModel->where('Telefon', $telefon)
                                        ->orWhere('Email', $email)
                                        ->first();

        if ($existingClient) {
            $errors['exists'] = 'Client with the provided phone number or email already exists!';
            return $this->response->setStatusCode(500)->setJson(['errors' => $errors]);
        }

        $clientData = [
            'Nume'          => strtolower($nume),
            'Prenume'     => strtolower($prenume),
            'Telefon'        => $telefon,
            'Email'           => strtolower($email),
        ];

        $clientiModel->insert($clientData);

        $leadModel = model("LeaduriModel");

        $leadData = [
            "IdClient"      => $clientiModel->insertId(),
            "Mesaj"         => strtolower($mesaj) 
        ];

        $leadModel->insert($leadData);

        return $this->response->setStatusCode(200)
                            ->setJson([
                                'id_client'     => $clientiModel->insertId(), 
                                'id_lead'       => $leadModel->insertId
                            ]);
    }

}
