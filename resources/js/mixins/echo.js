/**
 * Created by KevinPC on 29-7-2018.
 */
import { forIn } from 'lodash';

export default {
    created() {
        forIn(this.getEventHandlers(), (handler, eventName) => {
            window.Echo.channel('dashboard')
                .listen(`\\App\\Events\\${eventName}`, response => handler(response))
        });
    },
};
