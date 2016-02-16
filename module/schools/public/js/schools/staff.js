(function () {
    'use strict';

    var Staff,
        Teacher,
        StaffRow,
        StaffView,
        TeacherView,
        teacherTemplate;

    Teacher = Backbone.Model.extend({ idAttribute: 'id' });

    Staff = Backbone.Collection.extend({
        model: Teacher,
        comparator: 'surname'
    });

    StaffRow = Backbone.View.extend({
        tagName: 'tr',
        template: (function () {
            if (typeof teacherTemplate === 'undefined') {
                teacherTemplate = _.template($('#teacher-row').html());
            }
            return teacherTemplate;
        }()),
        initialize: function () {
            this.model.on('change', this.render, this);
            this.model.on('remove', this.remove, this);
        },
        render: function () {
            this.$el.html(this.template({ teacher: this.model.attributes }));
            this.$el.attr('data-id', this.model.get('id'));
            return this;
        },
        remove: function () {
            this.$el.remove();
        }
    });

    StaffView = Backbone.View.extend({
        el: '#school',
        teacherView: null,
        events: {
            'click .btn-add-teacher': 'addEmployee',
            'click tbody tr': 'editEmployee'
        },
        initialize: function () {
            var that = this;
            this.teacherView = new TeacherView({model: this.model});
            _.each(this.$el.find('tbody tr'), function (tr) {
                var data = $(tr).data('teacher'),
                    teacher = new Teacher(data);
                that.model.add(teacher);
                new StaffRow({ model: teacher, el: tr });
                $(tr).attr('data-teacher', null);
            });
            this.model.on('add', this.renderEmployee, this);
        },
        addEmployee: function (evt) {
            evt.preventDefault();
            this.teacherView.render();
            return this;
        },
        editEmployee: function (evt) {
            var teacherId;
            if ($(evt.target).is('a')) return;
            teacherId = $(evt.target).closest('tr').data('id');
            this.teacherView.render(teacherId);
            return this;
        },
        renderEmployee: function (teacher) {
            this.$el.find('tbody tr.no-records').remove();
            this.$el.find('tbody').append(new StaffRow({
                model: teacher
            }).render().el);
            return this;
        }
    });

    TeacherView = Backbone.View.extend({
        el: '#teacher-form-modal',
        form: null,
        teacher: null,
        url: null,
        events: {
            'submit form': 'persistTeacher',
            'click button.remove': 'removeTeacher',
        },
        initialize: function () {
            this.form = this.$el.find('form');
            this.url = this.form.data('url');
        },
        render: function (teacherId) {
            var teacherAttributes;
            this.form[0].reset();
            this.form.find('input[type="hidden"]').val('');
            if (!teacherId) {
                this.$el.find('.modal-footer button.remove').addClass('hidden');
            } else {
                this.$el.find('.modal-footer button.remove').removeClass('hidden');
            }
            this.teacher = teacherId && this.model.get(teacherId) || null;
            teacherAttributes = this.teacher && this.teacher.attributes || {};
            _.each(this.form[0].elements, function (element) {
                var element = $(element),
                    name = element.attr('name');
                if ('checkbox' === element.attr('type')) {
                    element.prop('checked', parseInt(teacherAttributes[name], 10));
                } else {
                    element.val(teacherAttributes[name] || '');
                }
            });
            this.show();
        },
        show: function () {
            this.$el.modal('show');
        },
        hide: function () {
            this.$el.modal('hide');
        },
        persistTeacher: function (evt) {
            var data = _.reduce(this.form.serializeArray(), function (hash, pair) {
                hash[pair.name] = pair.value;
                return hash;
            }, {});
            var that = this;
            evt.preventDefault();
            $.post(this.url, data).
                done(function(response){
                    if (that.teacher) {
                        that.teacher.set(response);
                    } else{
                        that.model.add(response);
                    }
                    that.hide();
                }).fail(function (xhr, err) {
                    alert(xhr.statusText);
                });
        },
        removeTeacher: function () {
            var that = this;
            if (!confirm('Να διαγραφεί ο εκπαιδευτικός;')) {
                return;
            }
            $.ajax({
                url: this.url + '/' + this.teacher.get('id'),
                type: 'delete',
                dataType: 'json'
            }).done(function () {
                that.model.remove(that.teacher.get('id'));
                that.hide();
            }).fail(function (xhr, err) {
                alert(xhr.statusText);
            });
        }
    });

    new StaffView({ model: new Staff() });
}());