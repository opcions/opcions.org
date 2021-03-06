<?php
/**
 * @file
 * Contains \Drupal\metatag_twitter_cards\Plugin\metatag\Tag\TwitterCardsAppUrlGooglePlay.
 */

namespace Drupal\metatag_twitter_cards\Plugin\metatag\Tag;

use Drupal\metatag\Plugin\metatag\Tag\MetaPropertyBase;

/**
 * The Twitter Cards app's custom URL scheme for Google Play metatag.
 *
 * @MetatagTag(
 *   id = "twitter_cards_app_url_googleplay",
 *   label = @Translation("Google Play app's custom URL scheme"),
 *   description = @Translation("The Google Play app's custom URL scheme (must include ""://"" after the scheme name)."),
 *   name = "twitter:app:url:googleplay",
 *   group = "twitter_cards",
 *   weight = 308,
 *   type = "string",
 *   multiple = FALSE
 * )
 */
class TwitterCardsAppUrlGooglePlay extends MetaPropertyBase {
}
