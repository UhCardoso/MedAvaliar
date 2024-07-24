<?php

class Review
{
    public $id;
    public $customer_services;
    public $quality_services;
    public $facilities_equipment;
    public $waiting_time;
    public $cost_benefit;
    public $review;
    public $is_anonymous;
    public $users_id;
    public $clinics_id;

    public $user; // váriavel de suporte no reviewDao getClinics
}

interface ReviewDAOInterface
{
    public function buildReview($data);
    public function create(Review $review);
    public function getclinicsReview($id);
    public function hasAlreadyReviewed($id, $userId);
    public function getRatings($id);
}
