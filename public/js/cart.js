/**
 * Created by piv on 01.04.15.
 */

$(document).ready(function(){

    function Cart(options){
        this.items = {};
        this.props = {};
        for (var k in options) {
            this.props[k] = options[k];
        }

        this.setProp = function(name, value){
            this.props[name] = value;
        };

        this.add = function(id, cost){
            if (!this.items.hasOwnProperty(id)) {
                this.items[id] = { count: 1, cost: cost }
            } else {
                this.items[id] = { count: 1 + this.items[id].count, cost: cost }
            }
            this.updated();
        };

        this.getCount = function() {
            var size = 0, key, obj = this.items;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) {
                    size += obj[key].count;
                }
            }
            return size;
        };

        this.getSum = function() {
            var sum = 0, key, obj = this.items;
            for (key in obj) {
                if (obj.hasOwnProperty(key)) {
                    sum += obj[key].count * obj[key].cost;
                }
            }
            return sum;
        };

        this.updated = function() {

            this.props['update'](this.getCount(), this.getSum());

            if (this.getCount()) {
                $(this.props['cartSelector']).show(0);
            } else {
                $(this.props['cartSelector']).hide(0);
            }
        }
    }

    var cart = new Cart({
        cartSelector: '#cart',
        update: function(count,sum) {
            console.log('called update');
            $('.count', '#cart').text(count);
            $('.sum', '#cart').text(sum);
        }
    });

    $(document).on('click', '.product-add', function(e){
        console.log('add ' + $(this).data('productId'));
        cart.add($(this).data('productId'), $(this).data('productCost'));
        e.preventDefault();
    });
});
