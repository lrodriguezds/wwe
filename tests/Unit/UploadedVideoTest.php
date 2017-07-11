<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\User;
use App\Uploaded_videos;

class UploadedVideoTest extends TestCase
{

    public function test_can_upload_video()
    {
        $user = User::find(1);

        $data = [
            'title' => 'Test video title',
            'user_id' => $user->id,
            'url' => 'test url',
            'location_id' => 1,
            'duration' => '0',
            'file_size' => '123',
            'format' => 'Test',
            'bit_rate' => '7200'
        ];

        $video = Uploaded_videos::create($data);

        $found_video = Uploaded_videos::find(1);

        $this->assertEquals($found_video->title, $data['title']);
        $this->assertEquals($found_video->user_id, $data['user_id']);
        $this->assertEquals($found_video->url, $data['url']);
        $this->assertEquals($found_video->location_id, $data['location_id']);
        $this->assertEquals($found_video->duration, $data['duration']);
        $this->assertEquals($found_video->file_size, $data['file_size']);
        $this->assertEquals($found_video->format, $data['format']);
        $this->assertEquals($found_video->bit_rate, $data['bit_rate']);
    }
}
