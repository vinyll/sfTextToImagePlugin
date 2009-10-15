<?php
class BaseTextToImageActions extends sfActions
{
/**Options can be :
 *   - preset : name of the settings setup in app_text_to_image_presets and containing the other available options
 *   - font_file : font file name relative to app_text_to_image_fonts_dir
 *   - font_size : size of the font in pixels
 *   - font_color : color of the font in hexadecimal, beginning with "#"
 *   - background_color : same for background, default: #FFFFFF
 *   - transparent_background : boolean. default true
 *   Options from "preset" are overridden by passed options arguments.
 */
  public function executeReplace(sfWebRequest $request)
  {
    $preset_name = $request->getParameter('preset');
    // Retrieve app values
    if($preset_name)
    {
      $presets = sfConfig::get('app_text_to_image_presets', array());
      if(!$presets[$preset_name])
      {
        throw new sfConfigurationException(sprintf('The Text To Image preset "%s" could not be found.', $preset_name));
      }
      extract($presets[$preset_name]);
    }
    // Override from request
    $font_file  = $request->getParameter('font_file', $font_file);
    $font_size  = $request->getParameter('font_size', $font_size ? $font_size : 13);
    $font_color = $request->getParameter('font_color', $font_color ? $font_color : '#000000');
    $background_color = $request->getParameter('background_color', $background_color ? $background_color : '#FFFFFF');
    $transparent_background  = $request->getParameter('transparent_background', $transparent_background ? $transparent_background : true);
    
    // Fix colors
    $font_color = $font_color[0] == '#' ? $font_color : '#'.$font_color;
    $background_color = $background_color[0] == '#' ? $background_color : '#'.$background_color;
    
    // sf settings
    $cache_images = sfConfig::get('sf_cache', true);
    $cache_folder = sfConfig::get('sf_module_cache_dir');
    
    // jitr file gets text value from hardcoded $_GET['text']
    $text = $request->getParameter('text');
    $text = $request->getParameter('encoded')
          ? base64_decode($text)
          : $text;
    
    $_GET['text'] = $text;
    $font_file = sfConfig::get('app_text_to_image_fonts_dir').'/'.$font_file;
    
    // Include source generator
    require_once dirname(__FILE__).'/../../../lib/vendor/jitr.php';
  }
}