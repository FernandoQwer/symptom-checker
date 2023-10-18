<?php

namespace Tests\Feature;

use App\Models\UserFeedback;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddUserFeedbackTest extends TestCase
{
    use RefreshDatabase;

    public function testUserFeedback()
    {
        $feedbackData = [
            'prediction_id' => 12,
            'rating' => 5,
            'comment'  => 'Accurate Prediction',
        ];

        // New User Feedback
        $user = UserFeedback::create($feedbackData);
        
        $this->assertDatabaseHas('user_feedbacks', ['prediction_id' => 12]);
    }
}
