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
        'client' : 'a26ca36e89284e03be9b47bd3b0f9cc7',
        'authRedirect' : 'http://garzadam.hensonism.com/',
        'apiDomain' : 'https://api.instagram.com/v1',
        'apiMaxCount' : 20
      },
      '$el' : {
        'form' : $('#insertagram-admin-form'),
        'buttonMore' : $('.insertagram__button--more'),
        'buttonSubmit' : $('.insertagram__button--submit'),
        'container' : $('#insertagram-gallery-admin'),
        'galleryAdmin' : $('.insertagram-gallery-admin-content'),
        'template' : {
          'figure' : $('#insertagram-template-admin-gallery-figure').html(),
          'inputs' : $('#insertagram-template-admin-gallery-inputs').html()
        }
      }
    }
    // extend instagram object
    this.config.instagram = _.extend(this.config.instagram, insertagramConfig.instagram);
    // extend and override any defaults from instantiation config
    this.config = _.extend(this.config, config);
    console.log('config admin', this.config);
  };

  /**
   * insertagram: methods and properties
   */
  window.Insertagram.prototype = {

    'fetch' : function (url, dataType, callback) {
      var self = this;
      $.ajax({
        'url' : url,
        'type' : 'GET',
        'dataType' : dataType,
        'cache' : false,
        'async' : true
      }).done(function(response) {
        callback.call(this, response);
      }).error(function(xhr) {
        console.log('ajax error: ', xhr);
      });
    },

    'getRecent' : function (userId, callback) {
      var self = this;
      var url = self.config.instagram.apiDomain + '/users/' + userId + '/media/recent/?count=' + self.config.instagram.apiMaxCount + '&access_token=' + self.config.instagram.token;
      self.fetch(url, 'jsonp', callback);
    },

    'bindEvents' : function ($el) {
      var self = this;
      $el.find('figure').off(); // clear events
      $el.find('figure').on('click', function(e) {
        e.preventDefault();
        var $this = $(this);
        var index = $this.attr('data-index');
        if($this.hasClass('active')) {
          self.config.$el.form.find('#insertagram-form-node-' + index).remove();
          $(this).removeClass('active');
        } else {
          var templateCompilerInputs = _.template(self.config.$el.template.inputs);
          var compiledTemplateInputs = templateCompilerInputs({
            'index' : index,
            'instagramId' : $this.attr('data-instagram_id')
          });
          self.config.$el.form.append(compiledTemplateInputs);
          $this.addClass('active');
        }
      });
      self.config.$el.buttonMore.off(); // clear events
      self.config.$el.buttonMore.on('click', function(e){
        e.preventDefault();
        var $this = $(this);
        var nextUrl = $(this).attr('data-url');
        $this.parent().addClass('loading');
        self.fetch(nextUrl, 'jsonp', function(response){
          $this.parent().removeClass('loading');
          self.displayRecent(response);
        });
      });
      self.config.$el.buttonSubmit.on('click', function(e){
        self.config.$el.container.addClass('loading--submit');
      });
    },

    'displayRecent' : function (data) {
      var self = this;
      var media = data.data;
      var nextUrl = (data.pagination && !data.pagination.next_url)
        ? false
        : data.pagination.next_url;
      self.config.$el.buttonSubmit.addClass('active');
      self.config.$el.container.addClass('active');
      for(var i=0; i < media.length; i++){
        var instagramId = (!media[i].id) ? '' : media[i].id;

        var templateCompilerFigure = _.template(self.config.$el.template.figure);
        var compiledTemplateFigure = templateCompilerFigure({
          'index' : i,
          'instagramId' : instagramId,
          'imageLowUrl' : media[i].images.low_resolution.url
        });

        self.config.$el.galleryAdmin.append(compiledTemplateFigure);

        if(i + 1 === media.length) {
          if(nextUrl) {
            self.config.$el.buttonMore.addClass('active');
            self.config.$el.buttonMore.attr('data-url', nextUrl);
          } else {
            self.config.$el.buttonMore.removeClass('active');
          }
          self.bindEvents(self.config.$el.galleryAdmin);
        }
      }
    },

    'initialize' : function () {
      var self = this;
      if(self.config.instagram.userId === '') {
        console.log('Insertagram: Instagram user ID is not set.');
      } else {
        self.getRecent(self.config.instagram.userId, function(response){
          self.displayRecent(response);
        });
      }
      $('#insertagram-btn-auth').on('click', function(e){
        e.preventDefault();
        var url = 'https://api.instagram.com/oauth/authorize/?client_id=' + self.config.instagram.client + '&redirect_uri=' + self.config.instagram.authRedirect + '&response_type=code';
        self.fetch(url, 'jsonp', function(response){
          console.log(response);
        });
      });
    }

  };

  if(window.insertagramConfig){
    var newInsertagram = new Insertagram();
    newInsertagram.initialize();
  }

})( window, jQuery, _ );