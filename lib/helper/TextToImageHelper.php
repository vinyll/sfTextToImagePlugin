<?php
/**
 * Converts a text into an image with alt text
 * @param string $text Text to convert
 * @param string $preset name of the preset in the config
 * @param array $options override of current preset options
 * @return string an image tag with an alternative text
 */
function text_image_tag($text, $preset, $options = array())
{
  $alt = isset($options['alt'])
       ? $options['alt']
       : $text
       ;
  
  return image_tag(
            url_for('text_to_image', array_merge(array('preset' => $preset, 'text' => base64_encode($text), 'encoded' => true), $options)),
            array('alt' => $alt)
          );
}