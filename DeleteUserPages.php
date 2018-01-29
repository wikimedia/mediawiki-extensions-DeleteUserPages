<?php
/**
 * DeleteUserPages extension
 *
 * @file
 * @ingroup Extensions
 * @author Ryan Schmidt
 * @license MIT
 * @link http://www.mediawiki.org/wiki/Extension:DeleteUserPages Documentation
 */

class DeleteUserPages {
	public static function onTitleQuickPermissions( $title, $user, $action, &$errors, $doExpensiveQueries, $short ) {
		if ( $action !== 'delete' || count( $errors ) > 0 ) {
			return true;
		}

		$ns = $title->getNamespace();
		$userName = $user->getName();
		$root = $title->getRootText();
		$text = $title->getText();

		if (
			( $ns === NS_USER || $ns === NS_USER_TALK )
			&& $userName === $root
			&& $title->userCan( 'edit' )
		) {
			if ( $root === $text && $user->isAllowed( 'delete-rootuserpages' ) ) {
				return false;
			} elseif ( $root !== $text && $user->isAllowed( 'delete-usersubpages' ) ) {
				return false;
			}
		}

		return true;
	}
}
