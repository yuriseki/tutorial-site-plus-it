<?php

namespace Drupal\site_plus_util;

use Drupal\file\Entity\File;
use Drupal\file\FileInterface;

/**
 * Class Util.
 *
 * @package Drupal\site_plus_util
 */
class Util {

  /**
   * Return the URL for an image with style applied.
   *
   * @param \Drupal\file\FileInterface $file
   * @param $style_name
   *
   * @return string
   *   The Url for the stylized image.
   *
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public static function getStylizedImageUrl(FileInterface $file, $style_name) {
    if (!$style_name) {
      return file_create_url($file->getFileUri());
    }

    $style = \Drupal::entityTypeManager()
      ->getStorage('image_style')
      ->load($style_name);
    if ($file instanceof File) {
      $image_nav_url = $style->buildUrl($file->getFileUri());
    }
    else {
      $image_nav_url = '';
    }

    return $image_nav_url;
  }

  /**
   * Get the field setting of an entity in a view mode.
   *
   * @param string $entity_type
   * @param string $bundle
   * @param string $view_mode
   * @param string $field_name
   *
   * @return array
   */
  public static function getFieldSettings($entity_type, $bundle, $view_mode, $field_name) {
    $settings = \Drupal::service('entity_type.manager')
      ->getStorage('entity_view_display')
      ->load($entity_type . '.' . $bundle . '.' . $view_mode)
      ->getRenderer($field_name)
      ->getSettings();

    return $settings;
  }

  /**
   * Render an entity.
   *
   * @param $entity
   * @param string $view_mode
   *
   * @return mixed|null
   */
  public static function renderEntity($entity, $view_mode = 'default') {
    if ($entity) {
      $langcode = $langcode = \Drupal::languageManager()
        ->getCurrentLanguage()
        ->getId();

      $view_builder = \Drupal::entityTypeManager()
        ->getViewBuilder($entity->getEntityTypeId());
      $view = $view_builder->view($entity, $view_mode, $langcode);

      return render($view);
    }
    else {
      return '';
    }
  }
}
