<?php

namespace Tests\Feature;

use App\Models\Prediction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddPredictionTest extends TestCase
{
    use RefreshDatabase;

    public function testUserFeedback()
    {
        $predictionData = [
            'prediction' => 'sample health condition',
            'score' => 70.00,
            'patient_id' => 2,
            'health_condition_id' => 1
        ];

        // New Prediction
        $prediction = Prediction::create($predictionData);

        $this->assertDatabaseHas('predictions', ['prediction' => 'sample health condition']);
    }
}
