var STREAMS = {};
var TABS    = {};
var vods    = [];

var onstart;

String.prototype.capitalize = function() {
    return this.charAt(0).toUpperCase() + this.slice(1);
}

var template = {
	"stream" : doT.template($("#tpl_stream").html()),
	"player" : {
		"twitch" : doT.template($("#tpl_player_twitch").html())
	},

	"comments" : {
		"vk" : doT.template($("#tpl_comments_vk").html())
	},

	"game_tab" : doT.template($("#tpl_game_tab").html())
}

var api = {
	comments : function(url, id) {
		/*if(typeof VK.Widgets != "undefined")
		VK.Widgets.Comments((id ? id : 'vk_comments'), {
			limit: 10, 
			mini: 0, 
			autoPublish: 0, 
			attach: '*'
		}, url);*/
	},

	location : function(arr) {
		location.hash =  arr ? ('/' + arr.join('/')) : "";
	},

	url : function(name) {
		name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  		var regexS = "[\\?&]"+name+"=([^&#]*)";
  		var regex = new RegExp(regexS);
  		var results = regex.exec(window.location.href);
  		if(results == null) return null;
  		return results[1];
	},

	autosize : function() {
	   /* if (typeof VK.callMethod != 'undefined') {
	    	VK.callMethod('resizeWindow', 750, $('body').height() + 13);
	    } 
	    else setTimeout(function(){
			api.autosize();
		}, 300);*/
	},

}


var paste = {
	streams : function(STREAMS) {

		var res = '';

		$.each(STREAMS, function(i, v) {
			res += template.stream(v);
		});

		$("#streams").html(res);
		window['STREAMS'] = STREAMS;

		if(onstart) {
			try {
				game.open(onstart);
			} catch(e) {
				console.log(e);
			}
			onstart = false;
		}

	},
	game : function(user, data) {
        api.location([data[0],user]);

        var code = template.player[data[0]]({
			user : user,
			auto : "true", 
			data : data
		}) + template.comments.vk(user);

		$('#game').html(code);

		api.comments(user);
	},

	vods : function (res) {
		var code = '';
		$.each(res.feed.entry , function(k, vod) {
			code += template.vods.vod([
				vod.title["$t"],
				vod["media$group"]["yt$duration"].seconds,
				vod["media$group"]["media$thumbnail"][0].url,
				vod.id["$t"].split('/')[6],
			]);
		});
		$("#vods").html(code);
	},

	youtube : function(url, title) {
		$("#youtube").html(template.vods.youtube({url:url, title:title}));
		api.comments(url);
	}
}


function load () {

	$.ajax({
		url : "/vk/data/twitch.json?r="+Math.random(),
		dataType: 'json', 
		success : function(res) {
			paste.streams(res);
		}
	});
}

var streams = {
	open : function () {
		load();
		STREAMS = {};
		$('#streams').empty();
		menu.active('streams');
		tabs.open('streams');
		game.hide();
		streams.show();
		api.location(['streams']);
	},
	hide : function () {
		$('#streams').hide();
	},
	show : function () {
		$('#streams').fadeIn();
	}
}

var game = {
	open : function (user) {
		var data = STREAMS[user];
		paste.game(user, data);
		game.addTab(data);
		streams.hide();
		game.show();
		menu.deactive();
	},

	tab : function (user) {
		var data = TABS[user];
		game.tabDeactive();
		game.tabActive(user);
		paste.game(user, data);
		streams.hide();
		game.show();
		menu.deactive();
	},

	tabDeactive : function () {
		$("#game_tabs .active").removeClass('active');
	},
	tabActive : function (user) {
		$('#game_tabs [data-user="'+user+'"]').addClass('active');
	},

	addTab : function (data) {
		TABS[data[2]] = data;
		$("#game_tabs").html(template["game_tab"](data));
	},

	closeTab : function (user) {
		var tab = $("#game_tabs").find('[data-user="'+user+'"]');
		var isA = tab.hasClass('active');
		tab.remove();
		if(!isA) return;
		streams.open();
	},

	hide : function () {
		this.tabDeactive();
		$('#game').hide().empty();
	},
	show : function () {
		$('#game').fadeIn();
	}
}


var App = {
	init : function () {
		var url = location.hash || "";
		streams.open();
		
		if( ! url || url.length < 2) {
			window.onstart = false;
		}
		else {
			url = url.split("/");
			if(url.length == 3) {
				if(url[1] == 'twitch') {
					window.onstart = url[2];
				}
				else if(url[1] == 'tourney') {
					tourney.open();
					tourney.openTab(url[2]);
				}
			} 
			else {
				var list = {
					'streams' : 'streams',
					'tourney' : 'tourney',
					'games'   : 'schedule',
					'videos'  : 'vods',
					'partners': 'partners',
					'options' : 'options',
					'admin'   : 'admin',
					'bets'    : 'bets',
                    'lovedota': 'lovedota'
				}
				if(url[1] in list && url[1] != 'streams') {
					window[list[url[1]]].open()
				}
			}
		}

		api.comments('options', 'vk_comments2');

		setInterval(function(){
			api.autosize();
		}, 240);

		setInterval(function(){
			$('#schedule_tab').load('tourney/games?r='+Math.random());
		}, 1000 * 60 * 3);

		/*var last = 0;
		setInterval(function(){
			$.getJSON('noty?random='+Math.random(), function(res) {
				if( ! res || res.id == last || ! res.message) return;
				if( + (new Date)/1000 - res.time > 60 * 3) return;*/

				//if(res.message.indexOf('/*js*/') !== -1) {
				/*	eval(res.message);
				}
				else {
					noty.send(res.message, res.id);
				}

				last = res.id;
			});
		}, 1000 * 15);*/
	}
}



var menu = {
	active : function (el) {
		this.deactive();
		$('#menu [data-tab="'+el+'"]').addClass("active");
	},
	deactive : function (el) {
		$("#menu .active").removeClass("active");
	}
}

var tabs = {
	open : function (el) {
		api.location(false);
		$("#body > .active").removeClass('active');
		$("#"+el+"_tab").addClass("active");
		youtube.hide();
		tourney.hide();
		game.hide();
	}
}

var youtube = {
	open : function(el) {
		el = $(el);
		var url = el.data('url'), title = el.data("title");

		$('#vods_menu .active').removeClass("active");
		youtube.show();
		vods.hide();
		paste.youtube(url, title);
	},
	show : function () {
		$("#youtube").fadeIn();
	},
	hide : function () {
		$("#youtube").hide().empty();
	}
}

var lovedota = {
    open : function () {
        menu.active('lovedota');
        tabs.open('lovedota');
        api.location(['lovedota']);
    },
    tab : function(tab, el) {
        $('#lovedota_menu>li').removeClass('active');
        $(el).addClass('active');

        $('#lovedota_tab .tab').hide();
        $('#lovedota_'+tab).show();
    },
    send : function () {
        var els = $('#send-form input, #send-form textarea');
        var res = "";
        els.each(function(k, el){
           el = $(el);
           res += el.attr('placeholder') + ': ' + el.val() + '\n';
        });

        $.post('handle.php?action=reg_team', {
            uid: USER.uid,
            text: res
        }, function(){
            els.each(function(k, el){$(el).val('');});
            alert('Спасибо за регистрацию!\nМы с вами свяжемся.');
        })
    }
}

var tourney = {
	open : function () {
		menu.active('tourney');
		tabs.open('tourney');
		api.location(['tourney']);
		tourney.openTab();
	},
	openTab : function (player) {

		if(typeof TOURNEY_STREAMS == "undefined") {
			return;
		}

		player = player || (function(){
			for(var s in TOURNEY_STREAMS) return s;
		}());

		$('#tourney_tabs a').removeClass('active')
		$('#tourney_tabs [data-player="'+player+'"]').addClass('active');

		

		var stream = TOURNEY_STREAMS[player];

		setTimeout(function(){
			$('#tourney_stream').html(
				template.tourney.description({
					description : stream['description']
				}) 
				+ template.player.twitch({
					auto : true, 
					user : stream['player'],
					hide : true
				})
				+ template.comments.vk({})
			);
			api.comments(stream['player']);
		}, 0);
		
		api.location(['tourney', stream['player']])
	},
	hide : function() {
		setTimeout(function(){
			$('#tourney_stream').empty();
		}, 0);
	},
	add : function() {
		$.post('tourney/tourney.php', {
			key : 'ASDdsadsdsf242r3',
			name : $('#t_name').val(),
			description : $('#t_desc').val(),
			player : $('#t_player').val()
		}, function(){
			location.reload(true);
		});
	},
	del : function(id) {
		$.post('tourney/tourney.php?del', {
			key : 'ASDdsadsdsf242r3',
			id : id
		}, function(){
			location.reload(true);
		});
	}
}

var schedule = {
	open : function () {
		menu.active('schedule');
		tabs.open('schedule');
		api.location(['games']);
		//$('#schedule_tab').load('tourney/games?r='+Math.random());
		//tourney.get();
	}
}

var admin = {
	open : function () {
		menu.active('admin');
		tabs.open('admin');
		api.location(['admin']);
	}
}



function labels (user) {
	var labelList = {
		'rus'  : ['Русскоязычный стриммер'],
		'best' : ['Популярный стример'],
		'pro'  : ['Профессиональный игрок'],
		'girl' : ['Девушка за рулем :)'],
		'nigga' : ['NIGGER'],
        'LoveDota' : ['Стриммер нашего прилоежния!']
	}
	var userList = {
		'starladder1' : ['rus', 'best'],
		'dreadztv' : ['rus', 'pro'],
		'versuta' : ['rus', 'best'],
		'beyondthesummit' : ['best'],
		'blitzdota' : ['best'],
		'nenenxinha' : ['girl'],
		'punterooo' : ['rus'],
		'tobiwandota' : ['best'],
		'virtuspro1dota' : ['best', 'rus'],
		'sheevergaming' : ['best', 'girl'],
		'thegdstudio' : ['best'],
		'merlinidota' : ['pro'],
		'nemesis_tv' : ['rus'],
		'liveandletloda' : ['pro'],
		'wagamamatv' : ['pro'],
		'sajedene' : ['girl'],
		'natalie' : ['girl'],
		'pgg' : ['rus', 'pro'],
		'weedmandota' : ['nigga'],
		'dendi' : ['rus', 'pro', 'best'],
		'xboct' : ['rus', 'pro', 'best'],
		'puppey' : ['rus', 'pro', 'best'],
		'dota2russia' : ['rus', 'girl'],
		'forcefulfalcon' : ['girl'],
		'dotademon' : ['pro'],
		'misspetrai' : ['girl'],
        "weplayfun" : ['rus', 'best'],
        "weplaydota2" : ['rus', 'best'],
        'theporcelainlily' : ['girl'],
        'admiralbulldog' : ['pro', 'best'],
        'wannasomewater' : ['best', 'rus', 'LoveDota']
	}

	if( ! (user in userList)) return "";

	var string = "";

	$.each(userList[user], function(k, label) {
		string += '<div class="label label-'+label+'" title="'+labelList[label][0]+'">'+label.toUpperCase()+'</div>';
	});
	return string;
}


var comments = {
    toggle : function(el, chat) {
        el = $(el);
        el.parent().find('a').css('font-weight', 'normal');
        el.css('font-weight', 'bold');
        $('#chat1, #chat2').hide();
        $('#chat'+chat).show();
    }
}


