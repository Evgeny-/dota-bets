(function () {
   moment.lang('ru');

   var times =$('.moment');

   for(var i=0; i<times.length; i++) {
      var el = times[i];
      updateTime(el);

      (function (el) {
         setInterval(function () {
            updateTime(el);
         }, 1000 * 60);
      }(el));
   }

   function updateTime(el) {
      var unix = el.getAttribute('time'),
          time = moment.unix(unix).fromNow();

      el.innerHTML = time;
   }

}());

(function () {
   var $inputs = $('[name="ratio1"], [name="ratio2"]');

   if($inputs.length !== 2) return;

   $inputs.bind('change', function () {
      var $el = $(this),
          val = + $el.val().replace(',', '.'),
          name = $el.attr('name'),
          inp = name.replace('ratio', ""),
          res = {
             'ratio1_per': 0, //проценты
             'ratio1_rel': 0, //относительные коэфф.
             'ratio2_per': 0, //проценты
             'ratio2_rel': 0 //относительные коэфф.
          };

      if(isNaN(val)) {
         $inputs.val(null);
         return alert('введите коэфф. числом');
      }

      if(val < 1) {
         $inputs.val(null);
         return alert('коэфф. должен быть больше 1');
      }

      if(val > 100) {
         return alert('Коэф. не может быть больше 99');
      }

      if(val < 10) {
         if(inp == 1) {
            res.ratio1_rel = val.toFixed(2);
            res.ratio1_per = Math.round(1 / val * 100);
            res.ratio2_rel = (val / (val - 1)).toFixed(2);
            res.ratio2_per = Math.round(1 / res.ratio2_rel * 100);
         }
         else {
            res.ratio2_rel = val.toFixed(2);
            res.ratio2_per = Math.round(1 / val * 100);
            res.ratio1_rel = (val / (val - 1)).toFixed(2);
            res.ratio1_per = Math.round(1 / res.ratio1_rel * 100);
         }
      }

      else {
         if(inp == 1) {
            res.ratio1_per = Math.round(val);
            res.ratio1_rel = (1 / val * 100).toFixed(2);
            res.ratio2_per = Math.round(100 - val);
            res.ratio2_rel = (1 / res.ratio2_per * 100).toFixed(2);
         }
         else {
            res.ratio2_per = Math.round(val);
            res.ratio2_rel = (1 / val * 100).toFixed(2);
            res.ratio1_per = Math.round(100 - val);
            res.ratio1_rel = (1 / res.ratio1_per * 100).toFixed(2);
         }
      }

      $inputs.eq(0).val(res.ratio1_per);
      $inputs.eq(1).val(res.ratio2_per);
      $('#ratio1').html(res.ratio1_per + '%, коэф. ' + res.ratio1_rel);
      $('#ratio2').html(res.ratio2_per + '%, коэф. ' + res.ratio2_rel);
   });

}());