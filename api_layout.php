<!--//////////////////////////////////////////////

LAYOUT FOR CONTENTFULL CONTENT

///////////////////////////////////////////////-->
<style>
div.col-sm-4 > img {
    max-width: 100%;
    margin-bottom: 20px;
    box-shadow: black 0px 0px 20px;
}
div.col-sm-4 {
    text-align: center;
}
div.jumbotron {
    background-color: #dce9f5;
    border-bottom-right-radius: 0px;
    border-bottom-left-radius: 0px;
}
div.main-container {
    background-color: cornsilk;
    margin-top: 20px;
    padding-right: 0px;
    padding-left: 0px;
    margin-bottom: 20px;
    border-radius: 0.3rem;
}

@media only screen and (max-width: 574px) {
div.main-container {
    margin-top: 0px;
    border-top-left-radius: 0px;
    border-top-right-radius: 0px;
}
}
</style>
<!--//////////////////////////////////////////////

INITIALIZE API CLASS AND INSTATE ENTRY ID

///////////////////////////////////////////////-->
<?php

require( 'api_class.php' );

$API = new contentful_conn( SPACE_ID, AUTH_TOKEN );
$API->get_entry( "2B4LTHXNPbEz1iYeYu11lP" );

?>
<!--//////////////////////////////////////////////

ITERATE THROUGH CONTENT

///////////////////////////////////////////////-->
<div class="container main-container">
  <div class="jumbotron text-center">
    <h1><?php echo $API->result_entry_array['title'] ?></h1>
    <h5>by <?php echo $API->result_entry_array['artist'] ?></h5>
    <p>
      <?php
      foreach ( $API->result_entry_array[ 'body' ][ 'content' ][ 0 ][ 'content' ] as $content ) {
        $style = ( count( $content[ 'marks' ] ) == 0 ) ? '' : 'font-style:' . $content[ 'marks' ][ 0 ][ 'type' ];
        ?>
      <span style="<?php echo $style; ?>"><?php echo $content['value']; ?></span>
      <?php
      }
      ?>
    </p>
  </div>
  <div class="container">
    <div class="container">
      <div class="row">
        <?php
        foreach ( $API->result_picture_array as $picture ) {
          $url = $picture[ 'info' ][ 'file' ][ 'url' ];
          $alt = $picture[ 'info' ][ 'title' ];
          ?>
        <div class="col-sm-4"> <img src="<?php echo $url ?>" alt="<?php echo $alt ?>" /> </div>
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
