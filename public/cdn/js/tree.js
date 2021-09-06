function renderUlTree(options) {
  var defaults = {
    $: window.$,
    elem: '',
    onItemClick: function () {
      console.log('点击目录项');
    },
    onItemToggle: function () {
      console.log('点击收缩目录');
    },
    options: [
      {
        type: 'up',
      },
      {
        type: 'down',
      },
      {
        type: 'set',
      },
      {
        type: 'delete',
      },
    ],
    onOptionTrigger: function (type, item, e) {
      switch (type) {
        case 'up':
          tthis.itemMoveUp(item)
          break;
        case 'down':
          tthis.itemMoveDown(item)
          break;
        case 'delete':
          tthis.itemDelete($(item).data('id'))
          break;

        default:
          break;
      }

    },
    list: []
  }
  var tthis = this;
  var settings = {};
  settings = $.extend({}, defaults, options);

  $ = settings.$;

  var thisDom = $(settings.elem);

  this.appendItem = function (data) {

    var defaults = {
      id: 0,
      pid: 0,
      title: 0,
      options: settings.options
    };

    var itemSetting = $.extend({}, defaults, data);

    settings.list.push(itemSetting);
    this.initList()
  }

  this.initList = function () {
    var list = settings.list;

    for (let initTimes = 0; initTimes < list.length; initTimes++) {
      list.forEach(item => {
        var itemFindKey = '.ul-tree-item.item-id-' + item.id;

        if (thisDom.find(itemFindKey).length > 0) {
          return true;
        }

        var itemParentFindKey = '.ul-tree-item.item-id-' + item.pid;

        var itemHtml = this.getItemTpl();

        if (item.pid == 0) {

          var itemDom = $(itemHtml).appendTo(settings.elem);
        } else {
          var itemDom = $(itemHtml).appendTo($(itemParentFindKey).children('.ul-tree-item-children'))
        }

        this.initItem(itemDom, item)

      });
    }

  };

  this.initItem = function (itemDom, item) {
    itemDom.data(item)

    itemDom.addClass('item-id-' + item.id)
    itemDom.children('.ul-tree-item-info').find('.ul-tree-item-title').text(item.title)


    itemDom.children('.ul-tree-item-info').find('.ul-tree-item-options').children().remove()

    item.options.forEach(option => {

      if (typeof option.type == "undefined") {
        option.type = 'set';
      }

      if (typeof option.className == 'undefined') {
        option.className = 'layui-icon layui-icon-' + option.type;
      }

      if (typeof option.html == 'undefined') {
        option.html = '<i class="' + option.className + '"></i>'
      }
      var domOption = $(option.html);

      domOption.addClass('ul-tree-item-options-item');
      domOption.data(option)
      itemDom.children('.ul-tree-item-info').find('.ul-tree-item-options').append(domOption);

    });
  }
  this.renderList = function () {
    thisDom.find('.ul-tree-item').each(function (index, elem) {

      tthis.renderItem(elem)
    })
  }
  this.renderItem = function (itemTree) {

    if ($(itemTree).data('is-rendered') == 1) {

      return true;
    }
    $(itemTree).data('is-rendered', 1)

    var parents = $(itemTree).parents('.ul-tree-item')

    var level = parents.length
    $(itemTree).find('.ul-tree-item-title').css('margin-left', (level + 1) * 15 + 5 + 'px')
    $(itemTree).find('.ul-tree-item-icon').css('left', (level + 1) * 15 - 15 + 'px')

    if ($(itemTree).children('.ul-tree-item-children').children().length == 0) {
      $(itemTree).children('.ul-tree-item-info').find('.ul-tree-item-icon').hide()
    } else {
      $(itemTree).children('.ul-tree-item-info').find('.ul-tree-item-icon').show()

    }

    $(itemTree).children('.ul-tree-item-info').click(function (e) {

      if ($(e.target).hasClass('ul-tree-item-icon')) {
        var iconItem = e.target
        if ($(iconItem).hasClass('layui-icon-triangle-d')) {
          // 收缩
          $(iconItem).removeClass('layui-icon-triangle-d')
          $(iconItem).addClass('layui-icon-triangle-r')

          $(itemTree).children('.ul-tree-item-children').hide()
        } else {
          // 展开
          $(iconItem).addClass('layui-icon-triangle-d')
          $(iconItem).removeClass('layui-icon-triangle-r')

          $(itemTree).children('.ul-tree-item-children').show()
        }

        settings.onItemToggle(itemTree,e)

      } else {
        if ($(e.target).closest('.ul-tree-item-options').length > 0) {

          settings.onOptionTrigger($(e.target).data('type'), itemTree, e)
        } else {
          settings.onItemClick(itemTree,e)

        }

      }
    })


  }

  this.itemMoveUp = function (item) {
    $(item).prev().insertAfter(item);
  }
  this.itemMoveDown = function (item) {
    $(item).next().insertBefore(item);
  }
  this.itemDelete = function (id) {
    var itemFindKey = '.ul-tree-item.item-id-' + id;
    $(itemFindKey).remove();

    var list = settings.list;

    var newList = [];

    list.forEach(data => {
      if (data.id == id || data.pid == id) {
        return true;
      }
      newList.push(data)
    });
    settings.list = list;
  }

  this.itemUpdate = function (newData) {

    var list = settings.list;

    var newList = [];

    list.forEach(data => {
      if (data.id == newData.id) {
        data = $.extend({}, data, newData);

        var itemFindKey = '.ul-tree-item.item-id-' + data.id;
        var item = $(itemFindKey);
        tthis.initItem(item, data)
      }
      newList.push(data)
    });
    settings.list = list;
  }

  this.getList = function () {
    var list = settings.list;

    list.forEach((data) => {
      var itemFindKey = '.ul-tree-item.item-id-' + data.id;
      var item = $(itemFindKey);
      data.index = item.index();
    });

    return list;
  }

  function itemTpl() {
    /* 
      <div class="ul-tree-item">
        <div class="ul-tree-item-info">
          <i class="ul-tree-item-icon layui-icon layui-icon-triangle-d"></i>
          <span class="ul-tree-item-title">读书笔记</span>
          <span class="ul-tree-item-options">
            
          </span>
        </div>
        <div class="ul-tree-item-children">
          
        </div>
      </div>
    */
  }

  this.getItemTpl = function () {
    var string = itemTpl.toString();

    return string.substring(string.indexOf("/*") + 3, string.lastIndexOf("*/"));
  }

  if (typeof options.list != 'undefined') {
    resetList(options.list);
  }

  function resetList(list) {
    settings.list = [];

    list.forEach(data => {
      tthis.appendItem(data)
    });
  }

  this.renderList()

}