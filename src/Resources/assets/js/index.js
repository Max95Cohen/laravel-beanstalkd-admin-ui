new Vue({
    el: '#app',
    data: {
        tubes: null,
    },
    methods: {
        fetchData: function () {
            $.get('/beanstalkd/api/tubes', function (response) {
                let tubes = response.tubes;

                if (!this.tubes) {
                    this.tubes = tubes;
                }

                let properties = [
                    'cmd-delete',
                    'cmd-pause-tube',
                    'current-jobs-buried',
                    'current-jobs-delayed',
                    'current-jobs-ready',
                    'current-jobs-reserved',
                    'current-jobs-urgent',
                    'current-using',
                    'current-waiting',
                    'current-watching',
                    'pause',
                    'pause-time-left',
                    'total-jobs',
                ];

                for (let t of tubes) {
                    for (let o of this.tubes) {
                        if (o.name === t.name) {
                            for (let p of properties) {
                                if (o[p] !== t[p]) {
                                    o[p] = t[p];
                                }
                            }
                        }
                    }
                }
            }.bind(this));
        }
    },
    ready: function () {
        this.fetchData();

        setInterval(function () {
            this.fetchData();
        }.bind(this), 5000);
    },
});

const targetNode = document.getElementById('tubes');
const config = {
    childList: true,
    subtree: true,
    characterData: true,
};

const callback = (list) => {
    for (const mutation of list) {
        if (mutation.type === 'characterData') {
            let t = mutation.target,
                p = t.parentNode;

            if (p.tagName === 'I') {
                p.className = 'f';

                setTimeout(function () {
                    p.className = '';
                }, 3000);
            }
        }
    }
};

const observer = new MutationObserver(callback);

observer.observe(targetNode, config);
