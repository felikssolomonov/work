define(['jquery'], function($){
    var CustomWidget = function () {
    	var self = this;
		this.callbacks = {
			render: function(){
                console.log('render');
                var html_data = '<a id="my_getcsv">DOWNLOAD</a>';
                self.render_template(
                    {
                        caption:{
                            class_name:'new_widget',
                        },
                        body: html_data,
                        render : ''
                    }
                );
				return true;
			},
			init: function(){
				console.log('init');
				return true;
			},
			bind_actions: function(){
				console.log('bind_actions');
				return true;
			},
			settings: function(){
				return true;
			},
			onSave: function(){
				alert('click');
				return true;
			},
			destroy: function(){
				
			},
            contacts: {
                selected: function(){
                    console.log('contacts');
                }
            },
			leads: {
					selected: function(){
                        console.log('leads');
                        var l_data = self.list_selected().selected;
                        var ids = [];
                        for (var i = 0; i < l_data.length; i++){
                            ids[i] = l_data[i].id;
                        }
                        $.ajax({
                            url:"http://127.0.0.1/dirWidget/index.php",
                            type: "POST",
                            data: 'ids='+ids,
                            success:function(result){
                                var type = 'data:application/octet-stream;base64, ';
                                result = result.split("&").join("\r\n");
                                console.log(result);
                                var base = btoa(unescape(encodeURIComponent(result)));
                                console.log(base);
                                var res = type + base;
                                $("#my_getcsv").attr('download', 'file.csv');
                                $("#my_getcsv").attr('href', res);
                            }
                        });
					}
				},
            tasks: {
                selected: function(){
                    console.log('tasks');
                }
            }
		};
		return this;
    };
return CustomWidget;
});