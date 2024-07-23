<?php

class Clinic
{
    public $id;
    public $name;
    public $description;
    public $image;
    public $location;
    public $category;
    public $state;
    public $city;
    public $neighborhood;
    public $users_id;

    public $rating;

    public function imageGenerateName()
    {
        return bin2hex(random_bytes(60)) . ".jpg";
    }
}

interface ClinicDAOInterface
{
    public function buildClinic($data);
    public function findAll();
    public function getLatestClinics();
    public function getClinicsByCategory($category);
    public function getClinicsByUserId($id);
    public function findById($id);
    public function search($title);
    public function create(Clinic $clinic);
    public function update(Clinic $clinic);
    public function destroy($id);
}
