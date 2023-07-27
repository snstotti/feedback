<?php


namespace App\UseCases;


use App\Models\Feedback;

class FeedbackUseCases
{
    public function acceptFeedback(AcceptFeedbackData $data): Feedback
    {
        $feedback = Feedback::make();
        $feedback->title = $data->title;
        $feedback->description = $data->description;
        $feedback->service_name = $data->service_name;
        $feedback->rating = $data->rating;
        $feedback->datetime = $data->datetime->format('Y-m-d H:i:s');
        $feedback->save();
        $feedback->refresh();

        return $feedback;
    }
}
