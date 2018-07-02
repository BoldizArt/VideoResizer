<?php
/**
 * @file
 * Contains Drupal\video_resizer\Controller\Resolutions; 
 */
namespace Drupal\video_resizer\Controller;

class Resolutions
{
    // Resolutions array
    protected $resolutions = [
        'hd_240p' => [
            'video' => [
                'width' => 426, 
                'height' => 240,
                'bitrate' => '4000k',
                'framerate' => 25
            ],
            'audio' => [
                'bitrate' => '128k',
                'samplingrate' => 22050 
            ]
        ],
        'sd_240p' => [
            'video' => [
              'width' => 426, 
              'height' => 240,
              'bitrate' => '800k',
              'framerate' => 25
            ],
            'audio' => [
              'bitrate' => '96k',
              'samplingrate' => 22050 
            ]
        ],
        'hd_360p' => [
            'video' => [
              'width' => 640, 
              'height' => 360,
              'bitrate' => '5000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '128k',
              'samplingrate' => 22050 
            ]
        ],
        'sd_360p' => [
            'video' => [
              'width' => 640, 
              'height' => 360,
              'bitrate' => '1000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '96k',
              'samplingrate' => 22050 
            ]
        ],
        'hd_480p' => [
            'video' => [
              'width' => 854, 
              'height' => 480,
              'bitrate' => '15000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '160k',
              'samplingrate' => 22050 
            ]
        ],
        'sd_480p' => [
            'video' => [
              'width' => 854, 
              'height' => 480,
              'bitrate' => '2500k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '128k',
              'samplingrate' => 22050 
            ]
        ],
        'hd_720p' => [
            'video' => [
              'width' =>1280, 
              'height' => 720,
              'bitrate' => '30000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '192k',
              'samplingrate' => 44100 
            ]
        ],
        'sd_720p' => [
            'video' => [
              'width' =>1280, 
              'height' => 720,
              'bitrate' => '5000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '160k',
              'samplingrate' => 44100 
            ]
        ],
        'hd_1080p' => [
            'video' => [
              'width' => 1920, 
              'height' => 1080,
              'bitrate' => '50000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '192k', 
              'samplingrate' => 44100 
            ]
        ],
        'sd_1080p' => [
            'video' => [
              'width' => 1920, 
              'height' => 1080,
              'bitrate' => '8000k',
              'framerate' => 30
            ],
            'audio' => [
              'bitrate' => '160k', 
              'samplingrate' => 44100 
            ]
        ]
    ];

    /**
     * Return an array with details of resolution, or error log.
     * @param string
     * 
     * @return array
     */
    public function get($resolution)
    {
      $resolution = (string)$resolution;

      // If exist an array with the $resolution key, return it.
      if (!empty($this->resolutions[$resolution])) {
        return $this->resolutions[$resolution];
      }

      // Create an error log with message.
      $message = t('Resolution @resolution does not exist.', ['@resolution' => $resolution]);
      \Drupal::logger('video_resizer')->error($message);

      return;
    }
}