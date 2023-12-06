<?php
//==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>==>>>
//
// Ajax Poll Script v3.02 [ GPL ]
// Copyright (c) phpkobo.com ( http://www.phpkobo.com/ )
// Email : admin@phpkobo.com
// ID : APSMX-302
//
//==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<==<<<

class CTClass extends CTClassBase
{
	function setupPoll( $poll ) {

		//-- Poll Title
		$poll->attr( "title", "¿Qué opinas del servicio?" );

		//-- Poll Options
		$poll->addItem( "Muy Bueno" );
		$poll->addItem( "Bueno" );
		$poll->addItem( "Regular" );
		$poll->addItem( "Malo" );
		

		//-- Text used in polls
		$poll->attr( "msg-vote", "Vote" );
		$poll->attr( "msg-select-one", "Por favor selecciona una opción" );
		$poll->attr( "msg-already-voted", "Tienes que elegir una opción" );
		$poll->attr( "msg-view-result", "Ver resultados" );
		$poll->attr( "msg-thank-you", "¡Gracias por tu voto!" );
		$poll->attr( "msg-return", "Regresar" );
		$poll->attr( "msg-total", "Total" );
		$poll->attr( "msg-reset-block", "Tu IP & ya está registrada" );
		$poll->attr( "msg-not-started", "La votación aún no inicia" );
		$poll->attr( "msg-ended", "La votación ha terminado, ¡Gracias!" );

		//-- Display "Reset IP & Cookie Block" button
		//--	Show: true
		//--	Hide: false
		$poll->attr( "b-reset-block", true );

		//-- Single selection or multiple selection
		//--	single selection: "radio"
		//--	multiple selection: "checkbox"
		$poll->attr( "vote-input", "radio" );

		//-- Specify the time delay on tool tips in milliseconds
		$poll->attr( "tip-box-duration", 2000 );

		//-- Prevent users from voting more than once by IP address
		//--	"true" or "false"
		$poll->attr( "enable-ip-block", true );

		//-- Prevent users from voting more than once by Cookie
		//--	"true" or "false"
		$poll->attr( "enable-cookie-block", true );

		//-- Specifiy the cookie's life span in seconds
		//--	(e.g.)　60*60*24 => One Day
		//--	(e.g.)　60*60*24*365 => One Year
		$poll->attr( "cookie-block-period", 60*60*24*365 );

		//-- Specifiy Start and End Date&Time:
		//-- Enter an empty string ("") if you don't need to specify it.
		//--	(e.g.)　"2010-01-02"
		//--	(e.g.)　"2015-03-01 15:20"
		$poll->attr( "dt-start", "" );
		$poll->attr( "dt-end", "" );

		//-- end
		return true;
	}
}

?>
