<script>
/**
* simplePagination.js v1.6
* A simple jQuery pagination plugin.
* http://flaviusmatis.github.com/simplePagination.js/
*
* Copyright 2012, Flavius Matis
* Released under the MIT license.
* http://flaviusmatis.github.com/license.html
*/

(function($){

	var methods = {
		init: function(options) {
			var o = $.extend({
				items: 1,
				itemsOnPage: 1,
				pages: 0,
				displayedPages: 5,
				edges: 2,
				currentPage: 0,
				hrefTextPrefix: '#page-',
				hrefTextSuffix: '',
				prevText: 'Prev',
				nextText: 'Next',
				ellipseText: '&hellip;',
				ellipsePageSet: true,
				cssStyle: 'light-theme',
				listStyle: '',
				labelMap: [],
				selectOnClick: true,
				nextAtFront: false,
				invertPageOrder: false,
				useStartEdge : true,
				useEndEdge : true,
				onPageClick: function(pageNumber, event) {
					// Callback triggered when a page is clicked
					// Page number is given as an optional parameter
				},
				onInit: function() {
					// Callback triggered immediately after initialization
				}
			}, options || {});

			var self = this;

			o.pages = o.pages ? o.pages : Math.ceil(o.items / o.itemsOnPage) ? Math.ceil(o.items / o.itemsOnPage) : 1;
			if (o.currentPage)
				o.currentPage = o.currentPage - 1;
			else
				o.currentPage = !o.invertPageOrder ? 0 : o.pages - 1;
			o.halfDisplayed = o.displayedPages / 2;

			this.each(function() {
				self.addClass(o.cssStyle + ' simple-pagination').data('pagination', o);
				methods._draw.call(self);
			});

			o.onInit();

			return this;
		},

		selectPage: function(page) {
			methods._selectPage.call(this, page - 1);
			return this;
		},

		prevPage: function() {
			var o = this.data('pagination');
			if (!o.invertPageOrder) {
				if (o.currentPage > 0) {
					methods._selectPage.call(this, o.currentPage - 1);
				}
			} else {
				if (o.currentPage < o.pages - 1) {
					methods._selectPage.call(this, o.currentPage + 1);
				}
			}
			return this;
		},

		nextPage: function() {
			var o = this.data('pagination');
			if (!o.invertPageOrder) {
				if (o.currentPage < o.pages - 1) {
					methods._selectPage.call(this, o.currentPage + 1);
				}
			} else {
				if (o.currentPage > 0) {
					methods._selectPage.call(this, o.currentPage - 1);
				}
			}
			return this;
		},

		getPagesCount: function() {
			return this.data('pagination').pages;
		},

		setPagesCount: function(count) {
			this.data('pagination').pages = count;
		},

		getCurrentPage: function () {
			return this.data('pagination').currentPage + 1;
		},

		destroy: function(){
			this.empty();
			return this;
		},

		drawPage: function (page) {
			var o = this.data('pagination');
			o.currentPage = page - 1;
			this.data('pagination', o);
			methods._draw.call(this);
			return this;
		},

		redraw: function(){
			methods._draw.call(this);
			return this;
		},

		disable: function(){
			var o = this.data('pagination');
			o.disabled = true;
			this.data('pagination', o);
			methods._draw.call(this);
			return this;
		},

		enable: function(){
			var o = this.data('pagination');
			o.disabled = false;
			this.data('pagination', o);
			methods._draw.call(this);
			return this;
		},

		updateItems: function (newItems) {
			var o = this.data('pagination');
			o.items = newItems;
			o.pages = methods._getPages(o);
			this.data('pagination', o);
			methods._draw.call(this);
		},

		updateItemsOnPage: function (itemsOnPage) {
			var o = this.data('pagination');
			o.itemsOnPage = itemsOnPage;
			o.pages = methods._getPages(o);
			this.data('pagination', o);
			methods._selectPage.call(this, 0);
			return this;
		},

		getItemsOnPage: function() {
			return this.data('pagination').itemsOnPage;
		},

		_draw: function() {
			var	o = this.data('pagination'),
				interval = methods._getInterval(o),
				i,
				tagName;

			methods.destroy.call(this);

			tagName = (typeof this.prop === 'function') ? this.prop('tagName') : this.attr('tagName');

			var $panel = tagName === 'UL' ? this : $('<ul' + (o.listStyle ? ' class="' + o.listStyle + '"' : '') + '></ul>').appendTo(this);

			// Generate Prev link
			if (o.prevText) {
				methods._appendItem.call(this, !o.invertPageOrder ? o.currentPage - 1 : o.currentPage + 1, {text: o.prevText, classes: 'prev'});
			}

			// Generate Next link (if option set for at front)
			if (o.nextText && o.nextAtFront) {
				methods._appendItem.call(this, !o.invertPageOrder ? o.currentPage + 1 : o.currentPage - 1, {text: o.nextText, classes: 'next'});
			}

			// Generate start edges
			if (!o.invertPageOrder) {
				if (interval.start > 0 && o.edges > 0) {
					if(o.useStartEdge) {
						var end = Math.min(o.edges, interval.start);
						for (i = 0; i < end; i++) {
							methods._appendItem.call(this, i);
						}
					}
					if (o.edges < interval.start && (interval.start - o.edges != 1)) {
						$panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
					} else if (interval.start - o.edges == 1) {
						methods._appendItem.call(this, o.edges);
					}
				}
			} else {
				if (interval.end < o.pages && o.edges > 0) {
					if(o.useStartEdge) {
						var begin = Math.max(o.pages - o.edges, interval.end);
						for (i = o.pages - 1; i >= begin; i--) {
							methods._appendItem.call(this, i);
						}
					}

					if (o.pages - o.edges > interval.end && (o.pages - o.edges - interval.end != 1)) {
						$panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
					} else if (o.pages - o.edges - interval.end == 1) {
						methods._appendItem.call(this, interval.end);
					}
				}
			}

			// Generate interval links
			if (!o.invertPageOrder) {
				for (i = interval.start; i < interval.end; i++) {
					methods._appendItem.call(this, i);
				}
			} else {
				for (i = interval.end - 1; i >= interval.start; i--) {
					methods._appendItem.call(this, i);
				}
			}

			// Generate end edges
			if (!o.invertPageOrder) {
				if (interval.end < o.pages && o.edges > 0) {
					if (o.pages - o.edges > interval.end && (o.pages - o.edges - interval.end != 1)) {
						$panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
					} else if (o.pages - o.edges - interval.end == 1) {
						methods._appendItem.call(this, interval.end);
					}
					if(o.useEndEdge) {
						var begin = Math.max(o.pages - o.edges, interval.end);
						for (i = begin; i < o.pages; i++) {
							methods._appendItem.call(this, i);
						}
					}
				}
			} else {
				if (interval.start > 0 && o.edges > 0) {
					if (o.edges < interval.start && (interval.start - o.edges != 1)) {
						$panel.append('<li class="disabled"><span class="ellipse">' + o.ellipseText + '</span></li>');
					} else if (interval.start - o.edges == 1) {
						methods._appendItem.call(this, o.edges);
					}

					if(o.useEndEdge) {
						var end = Math.min(o.edges, interval.start);
						for (i = end - 1; i >= 0; i--) {
							methods._appendItem.call(this, i);
						}
					}
				}
			}

			// Generate Next link (unless option is set for at front)
			if (o.nextText && !o.nextAtFront) {
				methods._appendItem.call(this, !o.invertPageOrder ? o.currentPage + 1 : o.currentPage - 1, {text: o.nextText, classes: 'next'});
			}

			if (o.ellipsePageSet && !o.disabled) {
				methods._ellipseClick.call(this, $panel);
			}

		},

		_getPages: function(o) {
			var pages = Math.ceil(o.items / o.itemsOnPage);
			return pages || 1;
		},

		_getInterval: function(o) {
			return {
				start: Math.ceil(o.currentPage > o.halfDisplayed ? Math.max(Math.min(o.currentPage - o.halfDisplayed, (o.pages - o.displayedPages)), 0) : 0),
				end: Math.ceil(o.currentPage > o.halfDisplayed ? Math.min(o.currentPage + o.halfDisplayed, o.pages) : Math.min(o.displayedPages, o.pages))
			};
		},

		_appendItem: function(pageIndex, opts) {
			var self = this, options, $link, o = self.data('pagination'), $linkWrapper = $('<li></li>'), $ul = self.find('ul');

			pageIndex = pageIndex < 0 ? 0 : (pageIndex < o.pages ? pageIndex : o.pages - 1);

			options = {
				text: pageIndex + 1,
				classes: ''
			};

			if (o.labelMap.length && o.labelMap[pageIndex]) {
				options.text = o.labelMap[pageIndex];
			}

			options = $.extend(options, opts || {});

			if (pageIndex == o.currentPage || o.disabled) {
				if (o.disabled || options.classes === 'prev' || options.classes === 'next') {
					$linkWrapper.addClass('disabled');
				} else {
					$linkWrapper.addClass('active');
				}
				$link = $('<span class="current">' + (options.text) + '</span>');
			} else {
				$link = $('<a data-value = "'+(pageIndex + 1)+'" href="' + o.hrefTextPrefix + (pageIndex + 1) + o.hrefTextSuffix + '" class="page-link">' + (options.text) + '</a>');
				$link.click(function(event){
					return methods._selectPage.call(self, pageIndex, event);
				});
			}

			if (options.classes) {
				$link.addClass(options.classes);
			}

			$linkWrapper.append($link);

			if ($ul.length) {
				$ul.append($linkWrapper);
			} else {
				self.append($linkWrapper);
			}
		},

		_selectPage: function(pageIndex, event) {
			var o = this.data('pagination');
			o.currentPage = pageIndex;
			if (o.selectOnClick) {
				methods._draw.call(this);
			}
			return o.onPageClick(pageIndex + 1, event);
		},


		_ellipseClick: function($panel) {
			var self = this,
				o = this.data('pagination'),
				$ellip = $panel.find('.ellipse');
			$ellip.addClass('clickable').parent().removeClass('disabled');
			$ellip.click(function(event) {
				if (!o.disable) {
					var $this = $(this),
						val = (parseInt($this.parent().prev().text(), 10) || 0) + 1;
					$this
						.html('<input type="number" min="1" max="' + o.pages + '" step="1" value="' + val + '">')
						.find('input')
						.focus()
						.click(function(event) {
							// prevent input number arrows from bubbling a click event on $ellip
							event.stopPropagation();
						})
						.keyup(function(event) {
							var val = $(this).val();
							if (event.which === 13 && val !== '') {
								// enter to accept
								if ((val>0)&&(val<=o.pages))
								methods._selectPage.call(self, val - 1);
							} else if (event.which === 27) {
								// escape to cancel
								$ellip.empty().html(o.ellipseText);
							}
						})
						.bind('blur', function(event) {
							var val = $(this).val();
							if (val !== '') {
								methods._selectPage.call(self, val - 1);
							}
							$ellip.empty().html(o.ellipseText);
							return false;
						});
				}
				return false;
			});
		}

	};

	$.fn.pagination = function(method) {

		// Method calling logic
		if (methods[method] && method.charAt(0) != '_') {
			return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
		} else if (typeof method === 'object' || !method) {
			return methods.init.apply(this, arguments);
		} else {
			$.error('Method ' +  method + ' does not exist on jQuery.pagination');
		}

	};

})(jQuery);
</script>

<div class="row">
	<div class="col s12 m3 l3">

		<form method="post" action="#" class="javascript" id="itsposttime">

			<input type="text" name="subject" class="javascript-subject" placeholder="Subject" />
			<input type="text" name="subject" class="javascript-location" placeholder="Location" />

			<select id="javascript-distance">
				<?php foreach(array(5,20,100,500,1000,5000,10000) as $distance): ?>
					<option value="<?php echo $distance; ?>"><?php echo numbers($distance,1); ?> Miles</option>
				<?php endforeach; ?>
			</select>
			<input type="text" name="subject" class="javascript-name" placeholder="Name" />
			<input type="text" name="subject" class="javascript-gender" placeholder="Gender" />
			<input type="text" name="subject" class="javascript-pricelow" placeholder="Price Low" />
			<input type="text" name="subject" class="javascript-pricehigh" placeholder="Price High" />

			<input type="text" name="subject" class="javascript-page" placeholder="Page" value="1" />
			<input type="text" name="subject" class="javascript-sort" placeholder="Page" value="lastactive" />

			<button type="submit" class="submit-a-form btn" data-form = "#itsposttime" >Submit</button>

		</form>


	</div>
	<div class="col s12 m9 l9">
		<div class="results-count"></div>
		<div class="results"></div>
		<div class="the-pages"></div>
	</div>
</div>







<input id="csrf" type="hidden" name="<?php echo $csrf_key; ?>" value="<?php echo $csrf_token; ?>">
<div class="hide" id="csrf_key"><?php echo $csrf_key; ?></div>
<div class="hide" id="csrf_token"><?php echo $csrf_token; ?></div>
<script src="/js/js.cookie.js"></script>


<script src="/js/mustache.js"></script>
<script type="text/javascript">

// window.navigator.geolocation.getCurrentPosition(function(pos){
//     console.log(pos);
// });

var getzipcode = Cookies.get('getzipcode');

if(getzipcode){
	$('.javascript-location').val(getzipcode);
}
else{
	window.navigator.geolocation.getCurrentPosition(function(pos){

		$.get( "http://maps.googleapis.com/maps/api/geocode/json?latlng=33.495904599999996,-111.9243226&sensor=true", function( data ) {
			var zipcode = data.results[0].address_components[7].long_name;
			if(zipcode){
				Cookies.set('getzipcode', zipcode, { expires: 7 });
				$('.javascript-location').val(zipcode);
			}
		});

	});
}

var decodeHtmlEntity = function(str) {
	return str.replace(/&#(\d+);/g, function(match, dec) {
		return String.fromCharCode(dec);
	});
};

var encodeHtmlEntity = function(str) {
	var buf = [];
	for (var i=str.length-1;i>=0;i--) {
		buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
	}
	return buf.join('');
};

    function build_results(results,count){
        //
        $.each( results, function( index,item ) {

            var view = {
              title: item.first_name,
              url:item.url,
              rate:item.hourly_rate,
              distance:item.distance,
              img:item.img,
			  location:item.city+', '+item.state_long
            };


			if(item.short_description_verified){
				view["desc"] = decodeHtmlEntity(item.short_description_verified);
			}
			if(item.personal_statement_verified){
				view["statement"] = decodeHtmlEntity(item.personal_statement_verified);
			}


			//console.log(view);

            var template = '<div class="imatutor" id="activeblock-'+index+'">';
                template +='<div class="row">';
                    template += '<div class="col s12 m4 l3 center-align">';
                        template += '<div class="image"> <img src="{{img}}" /> </div>';
                        template += '<div class="user-name"> <a href="{{url}}">{{title}}</a> </div>';
                        template += '<div class="tutor-location"><i class="mdi-action-room"></i> {{location}} </div>';
                        if(item.distance){
							template += '<div class="tutor-distance"> {{distance}} Miles Away </div>';
						}
                        template += '<div class="my-rate"> ${{rate}}<span>/ Hour</span> </div>';
                    template += '</div>';

                    template += '<div class="col s12 m8 l9">';
                        template += '<div class="row no-bottom">';
                            template += '<div class="col s12 m12 l8 my-info">';
                                template += '<div class="im-a-tutor-short"><a href="{{url}}">{{desc}}</a></div>';
                                template += '<div class="im-a-tutor-long">{{statement}}</div>';
                            template += '</div>';
                            template += '<div class="col s12 m12 l4">';
                                template += '<a class="btn btn-block blue" href="{{url}}">View Profile</a>';
                                template += '<a class="btn btn-block" href="{{url}}/send-message">Send Message</a>';

                                template += '<div class="badges"><div class="ajax-badges" id="urlstring--'+index+'" data-url="{{url}}"></div></div>';


                            template += '</div>';
                        template += '</div>';
                    template += '</div>';
                template += '</div>';

            template += '</div>';

            var output = Mustache.render(template, view);


            $('.results').append(output);
            //$('#activeblock-'+index).hide().removeClass('hide').delay(index * 300).fadeIn(100);

            var badgeid = '#urlstring--'+index;
            var badgeurl = item.url;
            $.ajax({
                type: 'POST',
                url: '/badges',
                data: {url:badgeurl,csrf_key:$('#csrf_key').html(),csrf_token:$('#csrf_token').html()},
                success: function(response){
                    $.each( response, function( key, value,index ) {
    					$(badgeid).append('<div class="action-badge '+key+'">'+value+'</div>');
    				});
                }
            });

        });

		build_pagination(count);
		//console.log('ALL DONE');
    }

	function makesurefocus(array){
		$.each(array, function( index, value ) {
			var itemvalue = $('.javascript-'+value).val();
			if(!itemvalue){
				$('.javascript-'+value).focus();
				return false;
			}
		});
	}

	function activate_voltron(formtarget){

		var thetoken = $('#csrf').val();
		var subject = $('.javascript-subject').val();
		var location = $('.javascript-location').val();

		var distance = document.getElementById("javascript-distance");
		var distance = distance.options[distance.selectedIndex].value;

		var name = $('.javascript-name').val();
		var gender = $('.javascript-gender').val();
		var pricelow = $('.javascript-pricelow').val();
		var pricehigh = $('.javascript-pricehigh').val();

		var page = $('.javascript-page').val();
		var sort = $('.javascript-sort').val();

		var buildtheurl = '/search/';
		if(subject){
			buildtheurl += subject+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(location){
			buildtheurl += location+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(distance){
			buildtheurl += distance+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(name){
			buildtheurl += name+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(gender){
			buildtheurl += gender+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(pricelow){
			buildtheurl += pricelow+'/';
		}
		else{
			buildtheurl += '---/';
		}

		if(pricehigh){
			buildtheurl += pricehigh+'/';
		}
		else{
			buildtheurl += '---/';
		}

		buildtheurl += page+'/';
		buildtheurl += sort+'/';

		$('.submit-a-form').attr('disabled','disabled');
		setTimeout(function(){
			$('.submit-a-form').removeAttr('disabled');
		},1000);

		makesurefocus(['subject','location','distance','gender','pricelow','pricehigh']);

		//console.log(buildtheurl);

		$.ajax({
			type: 'POST',
			url: buildtheurl,
			data: {csrf_token:thetoken},
			success: function(response){
				$('.results-count').html(response.count+' Tutors Found');
				$('.loading').fadeOut(function(){$(this).remove()});
				build_results(response.results,response.count);
				$('.results-count').append('<input type="text" class="totalcount" value="'+response.count+'" />');
			}
		});


	}

	function build_pagination(count){

		//var hash = window.location.hash;
		var hash = document.URL.substr(document.URL.indexOf('#')+1);
		if(!hash){
			hash = 1;
		}

		// PAGINATION
		//http://flaviusmatis.github.io/simplePagination.js/

		$('.the-pages').pagination({
	        items: count,
	        itemsOnPage: 10,
	        cssStyle: 'xxxpotato',
			hrefTextPrefix:'#',
			onPageClick:function(pageNumber,event){
				console.log(pageNumber);
				if(pageNumber>0){
					$('.javascript-page').val(pageNumber);
					$('#itsposttime').submit();
				}
			}
	    });

		if(hash){
			//$('.the-pages').pagination('selectPage', hash);
		}

		//$('.the-pages').pagination('selectPage', hash);


	}

	$(document).ready(function() {

		$('.javascript').on('submit',function(){

			$('.results').html('<div class="loading"><img src="/images/spin.svg"></div>');
			var formtarget = '#'+$(this).attr('id');
			activate_voltron(formtarget);
			return false;

		});

	});

</script>
<style type="text/css">
.loading{
background: #222;
left:0px;
top:0px;
z-index: 4444;
text-align: center;
display: block;
padding-top: 100px;
height: 60px;
opacity: .5;
position: fixed;
width: 100%;
height: 100%;
}
.loading img{
	max-height: 100%;
}
</style>
