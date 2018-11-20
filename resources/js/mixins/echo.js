/**
 * Created by KevinPC on 29-7-2018.
 */
import { forIn } from 'lodash';

export default {
    created() {
        let _self = this;
        forIn(this.getEventHandlers(), (handler, eventName) => {
            window.Echo.private('billing')
                .listen(`\\App\\Api\\Events\\${eventName}`, response => handler(response))

        });
    },
};
