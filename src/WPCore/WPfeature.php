<?php
/*
 * This file is part of WPCore project.
 *
 * (c) Louis-Michel Raynauld <louismichel@pweb.ca>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WPCore;

use WPCore\hooks\AdminScript;
use WPCore\hooks\ThemeScript;

/**
 * WP feature
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

abstract class WPfeature implements WPhook
{

  static $instance;

  public $name;

  protected $slug = 'pweb';

  private $base_path;
  private $base_url;

  private $asset_path = 'assets/';
  private $css_path   = 'css/';
  private $js_path    = 'js/';

  private $views_path = 'views/';

  protected $scripts = array();
  protected $styles  = array();

  protected $hooks   = array();

  protected $HThemeScript;
  protected $HAdminScript;

  protected $features = array();

  protected $enabled;

  public function __construct($name, $slug)
  {
    $this->name = $name;
    $this->slug = $slug;

    $this->enable();

    $this->setBaseUrl(get_template_directory_uri());
    $this->setBasePath(get_template_directory());

    $this->HThemeScript = new ThemeScript();
    $this->HadminScript = new AdminScript();
    $this->hook($this->HThemeScript);
    $this->hook($this->HadminScript);
  }

  abstract public static function getInstance();

  public function enable()
  {
    $this->enabled = true;
    add_theme_support($this->slug);
  }

  public function disable()
  {
    $this->enabled = true;
    remove_theme_support($this->slug);
  }

  public function register()
  {
    if($this->enabled === true)
    {
      if(!empty($this->hooks))
      {
        foreach($this->hooks as $hook)
        {
          $hook->register();
        }
      }
    }
  }

  public function remove()
  {
    if($this->enabled === true)
    {
      if(!empty($this->hooks))
      {
        foreach($this->hooks as $hook)
        {
          $hook->remove();
        }
      }
    }
  }

  public function addScript(WPscript $script)
  {
    if($script instanceof WPscriptTheme)
    {
      $this->HThemeScript->addScript($script);
    }
    elseif($script instanceof WPscriptAdmin)
    {
      $this->HadminScript->addScript($script);
    }
  }

  public function addStyle(WPstyle $style)
  {
    if($style instanceof WPstyleTheme)
    {
      $this->HThemeScript->addStyle($style);
    }
    elseif($style instanceof WPstyleAdmin)
    {
      $this->HadminScript->addStyle($style);
    }
  }

  public function hook(WPhook $hook)
  {
    $this->hooks[] = $hook;
  }

  public function setBasePath($basePath)
  {

    $this->base_path = rtrim($basePath, '/');
  }

  public function setBaseUrl($baseUrl)
  {
    $this->base_url = rtrim($baseUrl, '/');
  }
  /**
   * Get the theme path
   */
  public function getBasePath()
  {
    if ( !empty($this->base_path) ) return $this->base_path;

    return $this->base_path = get_template_directory();
  }
  /**
   * Get the theme assets path
   */
  public function getAssetsPath()
  {
    return $this->getBasePath().'/'.$this->asset_path;
  }

  /**
   * Get the theme path
   */
  public function getViewsPath()
  {
    return $this->getBasePath().'/'.$this->views_path;
  }
  /**
   * Get the theme path
   */
  public function getBaseUrl()
  {
    if ( !empty($this->base_url) ) return $this->base_url;

    return $this->base_url = get_template_directory_uri();
  }
  /**
   * Get the theme assets url
   */
  public function getAssetsUrl()
  {
    return $this->getBaseUrl().'/'.$this->asset_path;
  }

  /**
   * Get the theme css url
   */
  public function getCssUrl()
  {
    if ( !empty($this->css_url) ) return $this->css_url;

    return $this->css_url = $this->getBaseUrl().'/'.$this->asset_path.$this->css_path;
  }
  /**
   * Get the theme js url
   */
  public function getJsUrl()
  {
    if ( !empty($this->js_url) ) return $this->js_url;

    return $this->js_url = $this->getBaseUrl().'/'.$this->asset_path.$this->js_path;
  }

}