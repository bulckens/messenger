<?php

namespace Bulckens;

use Bulckens\Helpers\FileHelper;
use Bulckens\AppTools\App;
use Bulckens\AppTools\Traits\Configurable;

class Messenger {

  use Configurable;

  public function __construct( $message, $options = [] ) {
    // get nodifier path 
    $notifier = FileHelper::parent( 'utilities/terminal-notifier.app/Contents/MacOS/terminal-notifier', 2 );
    $icon     = App::root( $this->config( 'icon' ) );
    $title    = $this->config( 'title' );

    // add message
    $notifier .= " -message '$message'";

    // add image
    $notifier .= " -appIcon '$icon'";

    // add title
    if ( isset( $options['title'] ) )
      $notifier .= " -title {$options['title']}";
    else
      $notifier .= " -title 'Iconizer'";

    // add link
    if ( isset( $options['link'] ) )
      $notifier .= " -open {$options['link']}";

    exec( $notifier );
  }

}
