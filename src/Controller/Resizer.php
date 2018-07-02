<?php
/**
 * @file Contains Drupal\video_resizer\Controller\Resizer;
 */
namespace Drupal\video_resizer\Controller;

use Drupal\video_resizer\Interfaces\ResizerInterface;

class Resizer implements ResizerInterface
{
    // Resolution key
    protected $resolutionKey;

    // Input variables
    protected $inputUrl;
    protected $inputName;
    protected $inputExtension;

    // Output variables;
    protected $outputUrl;
    protected $outputName;
    protected $outputExtension;

    // Permission
    protected $permission;

    // Custom command
    private $customCommand = "";
    
    /**
     * Resize video file;
     */
    public function index()
    {
        // Check if any required variable is empty.
        if (empty($this->resolutionKey)) return t('The resolution key is empty!');
        if (empty($this->inputUrl)) return t('The input url is empty!');
        if (empty($this->inputName)) return t('The input name is empty!');
        if (empty($this->inputExtension)) return t('The input extension is empty!');

        // Add default value if any variable is empty
        if (empty($this->outputUrl)) $this->outputUrl = $this->inputUrl;
        if (empty($this->outputName)) $this->outputName = $this->inputName.'-'.$this->resolutionKey;
        if (empty($this->outputExtension)) $this->outputExtension = $this->inputExtension;

        // Get command.
        $cmd = $this->create();
        $response = $this->run($cmd);

        return $response;
    }

    /**
     * Set input variables.
     */
    public function setResolution($key)
    {
        $this->resolutionKey = $key;
    }

    /**
     * Set input variables.
     */
    public function setInput($url, $name, $extension)
    {
        $this->inputUrl = $url;
        $this->inputName = $name;
        $this->inputExtension = $extension;
    }

    /**
     * Set output variables.
     */
    public function setOutput($url, $name, $extension)
    {
        $this->outputUrl = $url;
        $this->outputName = $name;
        $this->outputExtension = $extension;
    }

    /**
     * Set file permission.
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * Add custom command
     */
    public function addCommand($command)
    {
        $this->customCommand = $command;
    }

    /**
     * @return string
     */
    protected function create()
    {
        // Get dimenzions.
        $resolution = \Drupal::service('video_resizer_resolutions');
        $dimensions = $resolution->get($this->resolutionKey);

        if (!empty($dimensions)) {
            // Get video and audio data.
            $video = $dimensions['video'];
            $audio = $dimensions['audio'];

            // Create command
            $cmd = "";

            // Open ffmpeg
            $cmd .= "/usr/bin/ffmpeg ";

            // Input file url
            $cmd .= "-i ";


            #### FILE INFO ####
            // Set file url
            $cmd .= $this->inputUrl;
            $cmd .= $this->inputName;
            $cmd .= ".";
            $cmd .= $this->inputExtension;
            $cmd .= " ";
            

            #### VIDEO OPTIONS ####
            // Set frame rate
            $framerate = $video['framerate'];
            $cmd .= "-r $framerate ";
            
            // Set frame size
            $framesize = $video['width'].'x'.$video['height'];
            $cmd .= "-s $framesize ";

            // Set bitrate
            $bitrate = $video['bitrate'];
            $cmd .= "-b $bitrate ";

          
            #### AUDIO OPTIONS ####
            // Set the audio sampling frequency.
            $samplingrate = $audio['samplingrate'];
            $cmd .= "-ar $samplingrate ";

            
            #### OUTPUT ####
            if (empty($output)) $output = $input;

            $cmd .= $this->outputUrl;
            $cmd .= $this->outputName;
            $cmd .= ".";
            $cmd .= $this->outputExtension;
            $cmd .= "; ";

            if (!empty($this->permission)) {
                #### ADD PERMISSION ####
                $cmd .= "chmod ";
                $cmd .= $this->permission;
                $cmd .= " ";
                $cmd .= $this->outputUrl;
                $cmd .= $this->outputName;
                $cmd .= ".";
                $cmd .= $this->outputExtension;
                $cmd .= "; ";
            }

            // Add command
            $cmd .= $this->customCommand;

            return $cmd;
        }
        return;
    }

    /**
     * @param string $code
     */
    protected function run($cmd)
    {
        if (is_string($cmd)) {
            exec($cmd, $out, $return);

            if ($return) {
                // Create an error log with message.
                $message = t('Error: @error', ['@error' => $return]);
                \Drupal::logger('video_resizer')->notice($message);

                return $message;
            } else {
                return true;
            }
        }
        return;
    }
}
