<?php

  /**
    This is the PodcastFeedHandler handler.

    This file contains the PodcastFeedHandler handler. The feed handler produces an
    RSS 2.0 iTunes podcast feed and is based on the default Urlaube FeedHandler class.

    @package urlaube\podcastfeedhandler
    @version 0.1a0
    @author  Yahe <hello@yahe.sh>
    @since   0.1a0
  */

  // ===== DO NOT EDIT HERE =====

  // prevent script from getting called directly
  if (!defined("URLAUBE")) { die(""); }

  function delay_PodcastFeedHandler() {
    class PodcastFeedHandler extends FeedHandler {

      // CONSTANTS
      // see https://help.apple.com/itc/podcasts_connect/#/itcb54353390

      // these have to be set via Handlers::set()
      const PODCAST_TITLE      = "podcast_title";
      const PODCAST_AUTHOR      = "podcast_author";
      const PODCAST_BLOCK       = "podcast_block";
      const PODCAST_CATEGORY    = "podcast_category";    // see https://help.apple.com/itc/podcasts_connect/#/itc9267a2f12
      const PODCAST_SUBCATEGORY = "podcast_subcategory"; // see https://help.apple.com/itc/podcasts_connect/#/itc9267a2f12
      const PODCAST_COMPLETE    = "podcast_complete";
      const PODCAST_DESCRIPTION = "podcast_description";
      const PODCAST_EXPLICIT    = "podcast_explicit";
      const PODCAST_IMAGE       = "podcast_image";
      const PODCAST_NEWFEEDURL  = "podcast_newfeedurl";
      const PODCAST_OWNER_EMAIL = "podcast_owner_email";
      const PODCAST_OWNER_NAME  = "podcast_owner_name";
      const PODCAST_TYPE        = "podcast_type";

      // these have to be set in the content file
      const BLOCK           = "block";
      const DESCRIPTION     = "description";
      const DURATION        = "duration";
      const ENCLOSURE       = "enclosure";
      const ENCLOSURELENGTH = "enclosurelength";
      const ENCLOSURETYPE   = "enclosuretype";
      const EPISODE         = "episode";
      const EPISODETYPE     = "episodetype";
      const EXPLICIT        = "explicit";
      const IMAGE           = "image";
      const SEASON          = "season";

      // RUNTIME FUNCTIONS

      public static function run() {
        $result = false;

        $metadata = static::parseUri(relativeuri());
        if (null !== $metadata) {
          // set the metadata to be processed by plugins
          Main::set(METADATA, $metadata);

          $content = preparecontent(static::getContent($metadata, $pagecount));
          if (null !== $content) {
            // check if the URI is correct
            $fixed = static::getUri($metadata);
            if (0 !== strcmp(value(Main::class, URI), $fixed)) {
              relocate($fixed.querystring(), false, true);
            } else {
              // set the content type
              header("Content-Type: application/rss+xml");

              // return a minimalistic RSS 2.0 feed
              print(fhtml("<?xml version=\"1.0\" encoding=\"UTF-8\" ?>".NL.
                          "<rss xmlns:itunes=\"http://www.itunes.com/dtds/podcast-1.0.dtd\" version=\"2.0\">".NL.
                          "  <channel>".NL.
                          "    <copyright>%s</copyright>".NL.
                          "    <link>%s</link>".NL.
                          "    <language>%s</language>".NL,
                          value(Themes::class, COPYRIGHT),
                          absoluteurl("/"),
                          strtr(value(Main::class, LANGUAGE), "_", "-")));

              if (null !== value(Handlers::class, static::PODCAST_TITLE)) {
                print(fhtml("    <title>%s</title>".NL.
                            "    <itunes:title>%s</itunes:title>".NL.,
                            value(Handlers::class, static::PODCAST_TITLE),
                            value(Handlers::class, static::PODCAST_TITLE)));
              } else {
                print(fhtml("    <title>%s</title>".NL.
                            "    <itunes:title>%s</itunes:title>".NL.,
                            value(Handlers::class, static::SITENAME),
                            value(Handlers::class, static::PODCAST_TITLE)));
              }
              if (null !== value(Handlers::class, static::PODCAST_AUTHOR)) {
                print(fhtml("    <itunes:author>%s</itunes:author>".NL,
                            value(Handlers::class, static::PODCAST_AUTHOR)));
              }
              if (null !== value(Handlers::class, static::PODCAST_BLOCK)) {
                print(fhtml("    <itunes:block>%s</itunes:block>".NL,
                            value(Handlers::class, static::PODCAST_BLOCK) ? "yes" : "no"));
              }
              if (null !== value(Handlers::class, static::PODCAST_CATEGORY)) {
                if (null !== value(Handlers::class, static::PODCAST_SUBCATEGORY)) {
                  print(fhtml("    <itunes:category text=\"%s\">".NL.
                              "      <itunes:category text=\"%s\" />".NL.
                              "    </itunes:category>".NL,
                              value(Handlers::class, static::PODCAST_CATEGORY),
                              value(Handlers::class, static::PODCAST_SUBCATEGORY)));
                } else {
                  print(fhtml("    <itunes:category text=\"%s\" />".NL,
                              value(Handlers::class, static::PODCAST_CATEGORY)));
                }
              }
              if (null !== value(Handlers::class, static::PODCAST_COMPLETE)) {
                print(fhtml("    <itunes:complete>%s</itunes:complete>".NL,
                            value(Handlers::class, static::PODCAST_COMPLETE) ? "yes" : "no"));
              }
              if (null !== value(Handlers::class, static::PODCAST_DESCRIPTION)) {
                print(fhtml("    <description>%s</description>".NL.
                            "    <itunes:summary>%s</itunes:summary>".NL,
                            value(Handlers::class, static::PODCAST_DESCRIPTION),
                            value(Handlers::class, static::PODCAST_DESCRIPTION)));
              } else {
                print(fhtml("    <description>%s</description>".NL.
                            "    <itunes:summary>%s</itunes:summary>".NL,
                            value(Themes::class, SITESLOGAN),
                            value(Themes::class, SITESLOGAN)));
              }
              if (null !== value(Handlers::class, static::PODCAST_EXPLICIT)) {
                print(fhtml("    <itunes:explicit>%s</itunes:explicit>".NL,
                            value(Handlers::class, static::PODCAST_EXPLICIT) ? "yes" : "no"));
              }
              if (null !== value(Handlers::class, static::PODCAST_IMAGE)) {
                print(fhtml("    <image>".NL.
                            "      <link>%s</link>".NL.
                            "      <title>%s - %s</title>".NL.
                            "      <url>%s</url>".NL.
                            "    </image>".NL.
                            "    <itunes:image href=\"%s\" />".NL,
                            absoluteurl("/"),
                            value(Themes::class, SITENAME),
                            value(Themes::class, SITESLOGAN),
                            value(Handlers::class, static::PODCAST_IMAGE),
                            value(Handlers::class, static::PODCAST_IMAGE)));
              }
              if (null !== value(Handlers::class, static::PODCAST_NEWFEEDURL)) {
                print(fhtml("    <itunes:new-feed-url>%s</itunes:new-feed-url>".NL,
                            value(Handlers::class, static::PODCAST_NEWFEEDURL)));
              }
              if ((null !== value(Handlers::class, static::PODCAST_OWNER_EMAIL)) &&
                  (null !== value(Handlers::class, static::PODCAST_OWNER_NAME))) {
                print(fhtml("    <itunes:owner>".NL.
                            "      <itunes:email>%s</itunes:email>".NL.
                            "      <itunes:name>%s</itunes:name>".NL.
                            "    </itunes:owner>".NL,
                            value(Handlers::class, static::PODCAST_OWNER_EMAIL),
                            value(Handlers::class, static::PODCAST_OWNER_NAME)));
              }
              if (null !== value(Handlers::class, static::PODCAST_TYPE)) {
                print(fhtml("    <itunes:type>%s</itunes:type>".NL,
                            value(Handlers::class, static::PODCAST_TYPE)));
              }

              if (null !== $content) {
                // make sure that we are handling an array
                if (!is_array($content)) {
                  $content = [$content];
                }

                foreach ($content as $content_item) {
                  print(fhtml("    <item>".NL));

                  if ($content_item->isset(TITLE)) {
                    print(fhtml("      <title>%s</title>".NL.
                                "      <itunes:title>%s</itunes:title>".NL,
                                value($content_item, TITLE),
                                value($content_item, TITLE)));
                  }
                  if ($content_item->isset(URI)) {
                    print(fhtml("      <link>%s</link>".NL.
                                "      <guid>%s</guid>".NL,
                                absoluteurl(value($content_item, URI)),
                                absoluteurl(value($content_item, URI))));
                  }
                  if ($content_item->isset(DATE)) {
                    $time = strtotime(value($content_item, DATE));
                    if (false !== $time) {
                      print(fhtml("      <pubDate>%s</pubDate>".NL,
                                  date("r", $time)));
                    }
                  }
                  if ($content_item->isset(static::BLOCK)) {
                    print(fhtml("      <itunes:block>%s</itunes:block>".NL,
                                istrue(value($content_item, static::BLOCK)) ? "yes" : "no"));
                  }
                  if ($content_item->isset(CATEGORY)) {
                    $categories = array_unique(explode(SP, strtolower(value($content_item, CATEGORY))));
                    foreach ($categories as $categories_item) {
                      print(fhtml("      <category>%s</category>".NL,
                                  trim($categories_item)));
                    }
                  }
                  if ($content_item->isset(static::DESCRIPTION)) {
                    print(fhtml("      <description>%s</description>".NL.
                                "      <itunes:summary>%s</itunes:summary>".NL,
                                value($content_item, static::DESCRIPTION),
                                value($content_item, static::DESCRIPTION)));
                  } else {
                    if ($content_item->isset(CONTENT)) {
                      print(fhtml("      <description>%s</description>".NL.
                                  "      <itunes:summary>%s</itunes:summary>".NL,
                                  value($content_item, CONTENT),
                                  value($content_item, CONTENT)));
                    }
                  }
                  if ($content_item->isset(static::DURATION)) {
                    print(fhtml("      <itunes:duration>%s</itunes:duration>".NL,
                                value($content_item, static::DURATION)));
                  }
                  if ($content_item->isset(static::ENCLOSURE) &&
                      $content_item->isset(static::ENCLOSURELENGTH) &&
                      $content_item->isset(static::ENCLOSURETYPE)) {
                    print(fhtml("      <enclosure url=\"%s\" length=\"%s\" type=\"%s\" />".NL,
                                value($content_item, static::ENCLOSURE),
                                value($content_item, static::ENCLOSURELENGTH),
                                value($content_item, static::ENCLOSURETYPE)));
                  }
                  if ($content_item->isset(static::EPISODE)) {
                    print(fhtml("      <itunes:episode>%s</itunes:episode>".NL,
                                value($content_item, static::EPISODE)));
                  }
                  if ($content_item->isset(static::EPISODETYPE)) {
                    print(fhtml("      <itunes:episodeType>%s</itunes:episodeType>".NL,
                                value($content_item, static::EPISODETYPE)));
                  }
                  if ($content_item->isset(static::EXPLICIT)) {
                    print(fhtml("      <itunes:explicit>%s</itunes:explicit>".NL,
                                istrue(value($content_item, static::EXPLICIT)) ? "yes" : "no"));
                  }
                  if ($content_item->isset(static::IMAGE)) {
                    print(fhtml("      <itunes:image href=\"%s\" />".NL,
                                value($content_item, static::IMAGE)));
                  }
                  if ($content_item->isset(static::SEASON)) {
                    print(fhtml("      <itunes:season>%s</itunes:season>".NL,
                                value($content_item, static::SEASON)));
                  }

                  print(fhtml("    </item>".NL));
                }
              }

              print(fhtml("  </channel>".NL.
                          "</rss>"));
            }

            // we handled this page
            $result = true;
          }
        }

        return $result;
      }

    }

    // register handler
    Handlers::register(PodcastFeedHandler::class, "run", PodcastFeedHandler::REGEX, [GET, POST], ERROR);
  }

  // as we extend a system handler and these are loaded AFTER the user handlers we have to delay the definition of our
  // user handler class until the system handlers have been loaded; therefore we register our extended handler right
  // before the handlers are executed
  Plugins::register(null, "delay_PodcastFeedHandler", "BEFORE_HANDLER");
