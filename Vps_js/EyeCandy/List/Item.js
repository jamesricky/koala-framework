Ext.namespace("Vps.EyeCandy.List");

Vps.EyeCandy.List.Item = function(cfg) {
    Ext.apply(this, cfg);
    this._init();
};

Ext.extend(Vps.EyeCandy.List.Item, Ext.util.Observable, {
    //list
    //listIndex
    //el
    _init: function() {
        this.addEvents({
            'mouseEnter': true,
            'mouseLeave': true,
            'click': true
        });

        this.state = [];

        Vps.Event.on(this.el, 'mouseEnter', function() {
            this.fireEvent('mouseEnter', this);
        }, this);
        Vps.Event.on(this.el, 'mouseLeave', function() {
            this.fireEvent('mouseLeave', this);
        }, this);
        Ext.fly(this.el).on('click', function(ev) {
            this.fireEvent('click', this, ev);
        }, this);
    },

    getState: function()
    {
        if (!this.state.length) return null;
        return this.state[this.state.length-1].state;
    },
    pushState: function(state, context)
    {
        //console.log('pushState', state, context);
        var curState = this.getState();        
        this.state.push({state: state, context: context});
        if (curState != this.getState()) {
            this.fireEvent('stateChanged', this);
        }
    },
    removeState: function(state, context)
    {
        var curState = this.getState();
        //console.log('removeState', state, context);
        for(var i=0; i<this.state.length; i++) {
            var s = this.state[i];
            if (s.state == state && s.context == context) {
                this.state.splice(i, 1);
                if (i == this.state.length && this.getState() != curState) {
                    this.fireEvent('stateChanged', this);
                }
                break;
            }
        }
    },

    getNextSibling: function()
    {
        return this.list.getItem(this.listIndex+1);
    },
    getPreviousSibling: function()
    {
        return this.list.getItem(this.listIndex-1);
    },

    getWidthIncludingMargin: function()
    {
        var w = this.el.getWidth();
        var margins = this.el.getMargins();
        w += margins.left + margins.right;
        return w;
    }
});