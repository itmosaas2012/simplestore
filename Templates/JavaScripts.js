/***************************************
 * Messages system
 **************************************/
$(function() {
    $(".message").addClass('alert');
    $(".message").prepend('<button type="button" class="close" data-dismiss="alert">&times;</button>');
    $(".message").wrap('<strong>');

    $(".message.error").addClass('alert-error');
    $(".message.info").addClass('alert-info');
    $(".message.success").addClass('alert-success');

    $(".close").click(function () {
        $(this).closest('.alert').slideUp('fast', function() {$(this).remove()});
    });
});

// Global namespace
window.SS = function() {
	// private:
	var translitTable = {
        'а': 'a',   'б': 'b',   'в': 'v',   'г': 'g',   'д': 'd',
        'е': 'e',   'ж': 'zh',   'з': 'z',   'и': 'i',   'й': 'y',
        'к': 'k',   'л': 'l',   'м': 'm',   'н': 'n',   'о': 'o',
        'п': 'p',   'р': 'r',   'с': 's',   'т': 't',   'у': 'u',
        'ф': 'f',   'х': 'kh',   'ц': 'ts',   'ч': 'ch',   'ш': 'sh',
        'щ': 'sch',   'ъ': '_',   'ы': 'y',   'ь': '',   'э': 'e',
        'ю': 'yu',   'я': 'ya',   ' ': '_'
    };
    // public:
	return {
		validateField: function(conf, strict) {
		    var res;
			if(typeof strict =='undefined')
				if(typeof conf[2] == 'undefined')
					var strict = false;
				else var strict = conf[2];
		    if(typeof conf[0]=='function')
		        res = conf[0].call(this, $(this).val());
		    else res = conf[0].test($(this).val());
			// r = res
			// s = hasClass('error')
			// S = strict
			/*r s	S	act
			0 0 0	-
			0 0 1	S
			0 1 0	-
			0 1 1	-
			1 0 0	-
			1 0 1	-
			1 1 0	R
			1 1 1	R*/
			var st = $(this).hasClass('error');
			if(res && st)
				$(this).removeClass('error').next('span').remove();
		    if(!res && !st && strict) {
		        var err = $("<span></span>");
		        err.html(conf[1]);
		        $(this).addClass('error').after(err);
		    }
		    return res;
		},

		validateForm: function(conf) {
	        return function() {
	            var res = true;
	            for(var p in conf) {
	                if(!conf.hasOwnProperty(p)) return;
	                var el = $(this).find('[name="'+p+'"]');
	                res = (!el.length || SS.validateField.call(el[0], conf[p], true))? res : false;
	            }
	            return res;
	        };
	    },
    
    	translit: function(str) {
    		var res = '';
		    for(var i=0; i<str.length; i++) {
		        var ch = str.charAt(i);
		        var chLow = ch.toLowerCase();
		        if(chLow>='a' && chLow<='z' || ch>='0' && ch<='9' || ch=='.' || ch=='-' || ch=='_')
		            res+= ch;
		        else if(translitTable.hasOwnProperty(chLow))
		            res+= ch==chLow? translitTable[chLow] : translitTable[chLow].toUpperCase();
		        else res+= '_';
		    }
		    return res;
		}
	};
}();

SS.newStaff = function() {
    var protectLogin = false;
    var formConfig = {
            surname: [
                /^[а-яa-z- ']+$/i,
                'Некорректная фамилия.'
            ], 
            name: [
                /^[а-яa-z- ']+$/i,
                'Некорректное имя.'
            ], 
            patronymic: [
                /^([а-яa-z- ']+)?$/i,
                'Некорректное отчество.'
            ], 
            workPlace: [
                /^.+$/i,
                'Не заполнено место работы.'
            ], 
            rank: [
                /^.+$/i,
                'Не указана должность.'
            ],
            phone: [
                /^[+0-9() -]{5,}$/i,
                'Телефон может содержать только цифры, скобки, знаки +, - и пробел (не менее 5 символов'
            ],
            email: [
            /* from: http://habrahabr.ru/post/55820/ */
                /^[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$/i,
                'Некорректный e-mail'
            ],
            passeportSerie: [
                /^\d{2} \d{2}$/i,
                'Формат серии: ## ##'
            ],
            passeportNumber: [
                /^\d{6}$/i,
                'Формат номера: ######'
            ],
            login: [
                /^[a-z0-9._-]+$/i,
                'Логин может содержать только символы латинского алфавита, цифры и знаки &quot;_&quot;, &quot;-&quot;, &quot;.&quot;.'
            ], 
            password: [
                /^.{8,}$/i,
                'Длина пароля должна быть не менее 8 символов.'
            ]
        };

    return {
	    init: function() {
		    $(function() {
		    	var $form = $('form.new-user-form');
				$form.on('submit', SS.validateForm(formConfig));
				$form.on('keyup', 'input', function() { SS.validateField.call(this, formConfig[this.name]); });
				$form.on('keydown', '[name="login"]', function() { protectLogin = true; });
				$form.on('keyup', '[name="surname"], [name="name"]', function() {
				    if(protectLogin) return true;
				    var str = $('[name="name"]').val();
				    var str2 = $('[name="surname"]').val();
				    if(str2.length && str.length) str+= '_';
				    str+= str2;
				    var res = SS.translit(str);
				    $('[name="login"]').val(res);
				});
				$form.on('click', 'a.new-workplace', function() {
    				var cl = $(this).parent().prev('.form-div');
    				var posId = parseInt(cl.find('select')[0].name.substring(9)) + 1;
    				var newPos = cl.clone();
    				newPos.html(cl.html().replace(/"(role|workPlace)(\d+)"/gi, '"$1'+posId+'"'));
    				cl.after(newPos);
    				$form.find('select.staff--workplace').each(function() {
    					var $o = $(this);
    					if(!$o.next().is('.staff--workplace-remove'))
    						$o.after($('<a href="#" class="staff--workplace-remove">&times;</a>'));
    				});
    				return false;
    			});
    			$form.on('click', 'a.staff--workplace-remove', function() {
    				var $cont = $(this).parent();
    				var $coll = $form.find('a.staff--workplace-remove'),
    					$last = $coll.last().parent(),
    					removed = $coll.index(this);
    				$(this).parent().slideUp('fast', function() {
    					$last.hide();
    					$(this).show();
    					for(var i=0; i<$coll.length-1; i++) {
	    					if(i<removed) continue;
	    					$form.find('#role'+(i+1)).val($form.find('#role'+(i+2)).val());
	    					$form.find('#workPlace'+(i+1)).val($form.find('#workPlace'+(i+2)).val());
	    				}
    					$last.remove();
    				});
    				if($coll.length==2)
    					$form.find('a.staff--workplace-remove').remove();
    				return false;
    			});
		    });
		}
	};
}();


SS.registerForm = function() {
    var formConfig = {
            adminLogin: [
                /^[a-z0-9._-]+$/i,
                'Логин может содержать только символы латинского алфавита, цифры и знаки &quot;_&quot;, &quot;-&quot;, &quot;.&quot;.',
				true
            ], 
            adminPassword: [
                /^.{8,}$/i,
                'Длина пароля должна быть не менее 8 символов.'
            ], 
            adminPasswordRepeated: [
                function(val) { return val == $('#adminPassword').val(); },
                'Введенные пароли не совпадают.',
				true
            ], 
            adminEmail: [
            /* from: http://habrahabr.ru/post/55820/ */
                /^[-a-z0-9!#$%&'*+\/=?^_`{|}~]+(?:\.[-a-z0-9!#$%&'*+\/=?^_`{|}~]+)*@(?:[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])?\.)*(?:aero|arpa|asia|biz|cat|com|coop|edu|gov|info|int|jobs|mil|mobi|museum|name|net|org|pro|tel|travel|[a-z][a-z])$/i,
                'Некорректный e-mail'
            ]
        };
    return {
    	init: function () {
    		$(function() {
    			var $form = $('form.register-form');
    			$form.on('submit', SS.validateForm(formConfig));
    			$form.on('keyup', 'input', function() { SS.validateField.call(this, formConfig[this.name]); });
    		});
    	}
    };
}();

SS.whGoodsManager = function() {
	return {
		init: function() {
			$(function() {
				var updateGoodName = function() {
					var val = $goodType.filter(':checked').val();
					if(val=='existent') {
						$('#newGoodName').parent().hide();
						$('#existentGoodName').parent().show();					
					} else {
						$('#newGoodName').parent().show();
						$('#existentGoodName').parent().hide();
					}
				};
				var $form = $('form.wh-goods-manager'),
					$goodType = $form.find('[name="goodType"]');
				$goodType.change(updateGoodName);
				updateGoodName();
			});
		},
	};
}();


SS.whLogist = function() {
    return {
	    init: function() {
		    $(function() {
		    	var $form = $('form.wh-logist-form');
				$form.on('submit', function() {
					var res = true;
					$form.find('.whLogist-goodCount').each(function() {
						res = res && SS.validateField.call(this, [function(val) {return val>0;}, 'Количество товара должно быть больше нуля.'], true);
					});
					res = res && SS.validateField.call($form.find('[name="responsible"]'), [/\S+/, 'Необходимо назначить ответственного.'], true);
					return res;
				});
				// $form.on('keyup', 'input', function() { SS.validateField.call(this, formConfig[this.name]); });
				$form.on('click', 'a.new-position', function() {
    				var cl = $(this).parent().prev('.form-div');
    				var posId = parseInt(cl.find('.whLogist-goodCount')[0].name.substring(9)) + 1;
    				var newPos = cl.clone();
    				newPos.html(cl.html().replace(/"(product|goodCount)(\d+)"/gi, '"$1'+posId+'"'));
    				cl.after(newPos);
    				$form.find('.whLogist-product').each(function() {
    					var $o = $(this);
    					if(!$o.next().is('.whLogist--product-remove'))
    						$o.after($('<a href="#" class="whLogist--product-remove">&times;</a>'));
    				});
    				return false;
    			});
    			$form.on('click', 'a.whLogist--product-remove', function() {
    				var $cont = $(this).parent();
    				var $coll = $form.find('a.whLogist--product-remove'),
    					$last = $coll.last().parent(),
    					removed = $coll.index(this);
    				$(this).parent().slideUp('fast', function() {
    					$last.hide();
    					$(this).show();
    					for(var i=0; i<$coll.length-1; i++) {
	    					if(i<removed) continue;
	    					$form.find('#product'+(i+1)).val($form.find('#product'+(i+2)).val());
	    					$form.find('#goodCount'+(i+1)).val($form.find('#goodCount'+(i+2)).val());
	    				}
    					$last.remove();
    				});
    				if($coll.length==2)
    					$form.find('a.whLogist--product-remove').remove();
    				return false;
    			});
		    });
		}
	};
}();