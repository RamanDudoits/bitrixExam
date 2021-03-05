
BX.ready(function(){
    BX.bindDelegate(
        document.body, 'click', {className: 'ajax-report' },
        function(e){
            if(!e) {
                e = window.event;
            }
            var get = {};
            get['REPORT_ADD'] = "Y";
            node = BX('ajax-report-text');
            if (!!node) {
                BX.ajax.get(
                    location.href,
                    get,
                    function (data) {
                        node.innerHTML = data;
                    }
                );
            }
            return BX.PreventDefault(e);
        }
    );
});