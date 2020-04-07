# PodcastFeedHandler handler
The PodcastFeedHandler handler is a handler generating RSS 2.0 podcast feeds that is based on the default Urlaube FeedHandler class.

## Installation
Place the folder containing the handler into your themes directory located at `./user/handlers/`.

## Configuration
To configure the handler you can change the corresponding settings in your configuration file located at `./user/config/config.php`.

### Podcast Author
You can set the following value to a string to define the podcast's author:
```
Handlers::set("podcast_author", NULL);
```

**iTunes recommends this setting.**

### Podcast Block
You can set the following value to `true` to define that the podcast should be removed from podcast listings:
```
Handlers::set("podcast_block", NULL);
```

### Podcast Category and Sub-Category
You can set the following values to strings to define the podcast's category and sub-category:
```
Handlers::set("podcast_category",    NULL);
Handlers::set("podcast_subcategory", NULL);
```

**iTunes requires this setting.**

### Podcast Complete
You can set the following value to `true` to define that the podcast will not receive more episodes:
```
Handlers::set("podcast_complete", NULL);
```

### Podcast Description
You can set the following value to a string to define the podcast's description:
```
Handlers::set("podcast_description", NULL);
```

**iTunes requires this setting.**

### Podcast Explicit
You can set the following value to `true` to define that the podcast contains explicit content:
```
Handlers::set("podcast_explicit", NULL);
```

**iTunes requires this setting.**

### Podcast Image
You can set the following value to a URL to define the podcast's image:
```
Handlers::set("podcast_image", NULL);
```

**iTunes requires this setting.**

### Podcast New-Feed-URL
You can set the following value to a URL to define the podcast's new feed URL to be fetched for future episodes:
```
Handlers::set("podcast_newfeedurl", NULL);
```

### Podcast Owner
You can set the following values to an e-mail address and string to define the podcast's owner:
```
Handlers::set("podcast_owner_email", NULL);
Handlers::set("podcast_owner_name",  NULL);
```

**iTunes recommends this setting.**

### Podcast Type
You can set the following value to `"episodic"` or `"serial"` to define the podcast's type:
```
Handlers::set("podcast_type", NULL);
```

## Usage

To use the handler you can add values to header of your content files located at `/user/content/*`.

### Block
You can set the following value to `true` to define that the episode should be removed from podcast listings:
```
Block: false
```

### Description
You can set the following value to a string to define the episode's description:
```
Description:
```

**iTunes recommends this setting.**

### Duration
You can set the following value to `<hh>:<mm>:<ss>` to define the episode's length:
```
Duration:
```

**iTunes recommends this setting.**

### Enclosure
You can set the following values to a URL, an integer and MIME-type string to define the episode's audio file:
```
Enclosure:
EnclosureLength:
EnclosureType:
```

**iTunes requires this setting.**

### Episode and Season
You can set the following values to integers to define the episode's season and number within the season:
```
Episode:
Season:
```

**iTunes requires this setting for podcasts of type `"serial"`.**

### EpisodeType
You can set the following value to `full`, `trailer` or `bonus` to define the episode's type:
```
EpisodeType:
```

### Explicit
You can set the following value to `true` to define that the episode contains explicit content:
```
Explicit:
```

**iTunes recommends this setting.**

### Image
You can set the following value to a URL to define the episode's image:
```
Image:
```

**iTunes recommends this setting.**
