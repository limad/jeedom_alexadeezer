<?php

/* This file is part of Jeedom.
 *
 * Jeedom is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Jeedom is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
 */

require_once dirname(__FILE__) . '/../../../core/php/core.inc.php';

/*
 * Plugin obsolète : seules les box qui l'utilisaient déjà peuvent l'activer.
 * Le core lance <id>_install() dans un sous-processus (jeePlugin.php) : une
 * exception levée ici ne bloquerait pas l'activation, on remet donc nous-mêmes
 * le plugin inactif.
 */
function alexadeezer_isLegacyUser() {
	if (config::byKey('legacyUser', 'alexadeezer', 0) == 1) {
		return true;
	}
	return count(eqLogic::byType('alexadeezer')) > 0;
}

function alexadeezer_blockNewActivation() {
	if (alexadeezer_isLegacyUser()) {
		config::save('legacyUser', 1, 'alexadeezer');
		return false;
	}
	config::save('active', 0, 'alexadeezer');
	config::save('dependancyAutoMode', 0, 'alexadeezer');
	$msg = __('Le plugin Alexa - Deezer est obsolète et ne peut plus être activé sur une nouvelle installation. Utilisez Alexa - Amazon Music (alexaamazonmusic) avec Alexa Premium (alexaapiv2).', __FILE__);
	log::add('alexadeezer', 'error', $msg);
	message::add('alexadeezer', $msg);
	return true;
}

function alexadeezer_install() {
	alexadeezer_blockNewActivation();
}

function alexadeezer_update() {
	config::save('legacyUser', 1, 'alexadeezer');
	alexadeezer::scanAmazonAlexa();
	foreach (eqLogic::byType('alexadeezer') as $alexadeezer) {
		$alexadeezer->save();
    	}
	//message::removeAll('Téléinfo');
    message::add('alexadeezer', 'Mise à jour du plugin Alexa-API terminée.', null, null);

}

?>
