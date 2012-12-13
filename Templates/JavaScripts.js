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
		validateField: function(conf) {
		    var res;
		    if(typeof conf[0]=='function')
		        res = conf[0].call(this, $(this).val());
		    else res = conf[0].test($(this).val());
		    $(this).removeClass('error').next('span').remove();
		    if(!res) {
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
	                res = (!el.length || SS.validateField.call(el[0], conf[p]))? res : false;
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
		    });
		}
	};
}();


SS.registerForm = function() {
    var formConfig = {
            adminLogin: [
                /^[a-z0-9._-]+$/i,
                'Логин может содержать только символы латинского алфавита, цифры и знаки &quot;_&quot;, &quot;-&quot;, &quot;.&quot;.'
            ], 
            adminPassword: [
                /^.{8,}$/i,
                'Длина пароля должна быть не менее 8 символов.'
            ], 
            adminPasswordRepeated: [
                function(val) { return val == $('#adminPassword').val(); },
                'Введенные пароли не совпадают.'
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