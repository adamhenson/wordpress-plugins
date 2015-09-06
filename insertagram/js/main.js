;(function ( window, $, _, undefined ) {

  /**
   * insertagram
   *
   * @param {object=} `config` Options for styled with
   */
  window.Insertagram = function (config) {
    // defaults
    this.config = {
      'instagram' : {
        'apiDomain' : 'https://api.instagram.com/v1',
        'apiMaxCount' : 20
      },
      'template' : {
        'figure' : $('#insertagram-template-gallery-figure').html(),
        'figureOverlay' : $('#insertagram-template-gallery-figure-overlay').html()
      }
    }
    // extend instagram object
    this.config.instagram = _.extend(this.config.instagram, insertagramConfig.instagram);
    this.config.instances = insertagramConfig.instances;
    this.config.feeds = insertagramConfig.feeds;
    // extend and override any defaults from instantiation config
    this.config = _.extend(this.config, config);
  };

  /**
   * insertagram: methods and properties
   */
  window.Insertagram.prototype = {

    'fetch' : function (url, callback) {
      var self = this;
      $.ajax({
        url : url,
        type : 'GET',
        dataType : 'jsonp',
        cache : false,
        async : true
      }).done(function(response) {
        callback.call(this, response);
      }).error(function(xhr) {
        console.log('ajax error: ', xhr);
      });
    },

    'bindEvents' : function ($el) {
      var self = this;
      var $buttonMore = $el.find('.insertagram__button--more');
      $buttonMore.on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        var nextUrl = $this.attr('data-next');
        var feedIndex = $this.attr('data-feed');
        $this.parent().addClass('loading');
        setTimeout(function(){ 
          $this.remove();
        }, 300);
        self.fetch(nextUrl, function(response){
          self.displayFeed(response, feedIndex);
          $this.parent().removeClass('loading');
          $this.remove();
        });
      });
    },

    'getMediaData' : function (mediaId, callback) {
      var self = this;
      var url = self.config.instagram.apiDomain + '/media/' + mediaId + '?access_token=' + self.config.instagram.token;
      self.fetch(url, callback);
    },

    'getRecent' : function (userId, callback) {
      var self = this;
      var url = self.config.instagram.apiDomain + '/users/' + userId + '/media/recent/?count=' + self.config.instagram.apiMaxCount + '&access_token=' + self.config.instagram.token;
      self.fetch(url, callback);
    },

    'displayMedia' : function ($el, media, info) {
      var self = this;
      var overlay = '';
      var infoClass = '';
      var caption = (media.caption && media.caption.text && (media.caption.text !== ''))
        ? media.caption.text
        : false;
      if (info) {
        var templateCompilerOverlay = _.template(self.config.template.figureOverlay);
        var compiledTemplateOverlay = templateCompilerOverlay({
          'username' : media.user.username,
          'profilePicture' : media.user.profile_picture,
          'caption' : caption,
          'likesCount' : media.likes.count,
          'commentsCount' : media.comments.count
        });
        overlay = compiledTemplateOverlay;
        infoClass = ' insertagram--info';
      }
      var templateCompilerFigure = _.template(self.config.template.figure);
      var compiledTemplateFigure = templateCompilerFigure({
        'userId' : media.user.id,
        'infoClass' : infoClass,
        'overlay' : overlay,
        'mediaLink' : media.link,
        'imageStandardUrl' : media.images.standard_resolution.url
      });
      $el.find('.insertagram-gallery').append(compiledTemplateFigure);
      setTimeout(function(){ 
        $el.find('a').addClass('active');
      }, 150);
    },

    'displayFeed' : function (data, feedIndex) {
      var self = this;
      var feed = self.config.feeds[feedIndex];
      var medias = data.data;
      var nextUrl = (data.pagination && data.pagination.next_url)
        ? data.pagination.next_url
        : false;
      var $el = $('#insertagram-container-' + feed.id);
      if(nextUrl){
        var $preloader = '<div class="insertagram__preloader"><div></div><div></div><div>';
        var $btnMore = $('<button class="insertagram__button--more" data-next="' + nextUrl + '" data-feed="' + feedIndex + '">' + $preloader + '</div></div>More</button>');
        $el.append($btnMore);
        setTimeout(function(){ 
          $btnMore.addClass('active');
        }, 300);
      }
      for(var i=0; i < medias.length; i++){
        var media = medias[i];
        self.displayMedia($el, media, feed.info);
        if (i === medias.length - 1) self.bindEvents($el);
      }
    },

    'initialize' : function () {
      var self = this;
      console.log('config', self.config);

      // display media
      if(self.config.instances.length > 0) {
        for(var i=0; i < self.config.instances.length; i++){
          var instance = self.config.instances[i];
          self.getMediaData(instance.id, function(response){
            var $el = $('#insertagram-container-' + instance.timestamp);
            self.displayMedia($el, response.data, instance.info);
          })
        }
      }

      // display feed
      if(self.config.feeds.length > 0){
        for(var feedCount=0; feedCount < self.config.feeds.length; feedCount++){
          var feedIndex = feedCount;
          self.getRecent(self.config.instagram.userId, function(response){
            self.displayFeed(response, feedIndex);
          });
        }
      }
    }

  };

  if(window.insertagramConfig){
    var newInsertagram = new Insertagram();
    newInsertagram.initialize();
  }

})( window, jQuery, _ );