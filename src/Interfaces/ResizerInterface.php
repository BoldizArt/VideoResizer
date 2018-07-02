<?php
/**
 * @file
 * Contains Drupal\video_resizer\Interfaces\ResizerInterface;
 */
namespace Drupal\video_resizer\Interfaces;

interface ResizerInterface
{
    public function index();
    public function setResolution($key);
    public function setInput($url, $name, $extension);
    public function setOutput($url, $name, $extension);
}