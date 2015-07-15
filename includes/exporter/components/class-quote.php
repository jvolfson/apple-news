<?php
namespace Exporter\Components;

/**
 * An HTML's blockquote representation.
 *
 * @since 0.2.0
 */
class Quote extends Component {

	/**
	 * Quotes cannot be anchor targets.
	 */
	protected $can_be_anchor_target = false;

	public static function node_matches( $node ) {
		if ( 'blockquote' == $node->nodeName ) {
			return $node;
		}

		return null;
	}

	protected function build( $text ) {
		preg_match( '#<blockquote.*?>(.*?)</blockquote>#si', $text, $matches );
		$text = $matches[1];

		$this->json = array(
			'role'   => 'quote',
			'text'   => $this->markdown->parse( $text ),
			'format' => 'markdown',
		);

		$this->set_style();
	}

	private function set_style() {
		$this->json[ 'textStyle' ] = 'default-pullquote';
		$this->register_style( 'default-pullquote', array(
			'fontName' => $this->get_setting( 'pullquote_font' ),
			'fontSize' => $this->get_setting( 'pullquote_size' ),
			'textColor' => $this->get_setting( 'pullquote_color' ),
			'textTransform' => $this->get_setting( 'pullquote_transform' ),
			'relativeLineHeight' => 0.7,
		) );
	}

}

