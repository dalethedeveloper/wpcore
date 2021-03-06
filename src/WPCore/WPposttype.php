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

/**
 * WP post type
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */

class WPposttype extends WPaction
{
  protected $slug;
  protected $args;

  public function __construct($slug , $args = array() )
  {
    parent::__construct('init');
    $this->slug = $slug;

    $defaults = array();
    $this->args = wp_parse_args($args, $defaults);

  }

  public function getSlug()
  {
    return $this->slug;
  }

  public function action()
  {
      register_post_type( $this->slug , $this->args );
  }

}