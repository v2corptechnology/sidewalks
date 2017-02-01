Vue.component('schedules', {
    template: `
            <div>
                <div class="form-group" v-for="(schedule, index) in schedules">
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-6">
                                <input class="form-control input-sm" type="time" id="from" placeholder="10:00am" required v-model="schedule.start">
                            </div>
                            <div class="col-sm-6">
                                <input class="form-control input-sm" type="time" id="from" placeholder="10:00am" required v-model="schedule.end">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="btn-group btn-group-xs btn-group-justified">
                            <label class="btn btn-default" :class="isActiveDay(day, index) ? 'active' : ''" v-for="day in days">
                                <input class="sr-only" type="checkbox" autocomplete="off" :checked="isActiveDay(day, index)" @click="toggleDay(day, index)"> {{ day }}
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <a href="#" v-show="index" @click="removeSchedule(index)">&times;</a>
                    </div>
                </div>
                <button class="btn btn-default btn-xs" type="button" @click="addSchedule">Add Hours</button>
                <input type="hidden" name="schedules" :value="JSON.stringify(schedules)"/>
            </div>
    `,
    data() {
        return {
            schedules: [],
            days: {1: 'Mon', 2:'Tue', 3:'Wed', 4:'Thu', 5:'Fri', 6:'Sat', 7:'Sun'},
            defaultSchedule: {start: '07:30', end: '12:30', days: ['Mon']},
        };
    },
    mounted() {
        this.addSchedule();
    },
    methods: {
        addSchedule() {
            this.schedules.push(JSON.parse(JSON.stringify(this.defaultSchedule)));
        },
        removeSchedule(index) {
            this.schedules.splice(index, 1);
        },
        isActiveDay(day, index) {
            return this.schedules[index].days.indexOf(day) != -1;
        },
        toggleDay(day, index) {
            var indexOfDay = this.schedules[index].days.indexOf(day);

            if (indexOfDay != -1) {
                this.schedules[index].days.splice(indexOfDay, 1);
            } else {
                this.schedules[index].days.push(day);
            }
        },
    }
});