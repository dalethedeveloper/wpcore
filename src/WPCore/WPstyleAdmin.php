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
 * WP style admin
 *
 * @author Louis-Michel Raynauld <louismichel@pweb.ca>
 */
class WPstyleAdmin extends WPstyle
{
  protected $admin_page = array();


  public function __construct($admin_page, $handle, $src = "", $deps = array(),$ver = false, $media = 'all')
  {
    parent::__construct($handle, $src, $deps, $ver, $media);

    if(!is_array($admin_page))
    {
      $this->admin_page[] = $admin_page;
    }
    else
    {
      $this->admin_page = $admin_page;
    }

  }

  public function is_needed($page)
  {
    if(empty($this->admin_page)) return true;

    return in_array($page, $this->admin_page);
  }

  public function enqueue($page)
  {
    if($this->is_needed($page))
    {
      parent::enqueue();
    }
  }
}