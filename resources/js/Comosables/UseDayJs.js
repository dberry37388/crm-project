import dayjs from "dayjs";
import utc from "dayjs/plugin/utc";
import timezone from "dayjs/plugin/timezone";

dayjs.extend(utc);
dayjs.extend(timezone);
dayjs.tz.setDefault(dayjs.tz.guess());

export function UseDayJs() {
    function formatDateFromString(date) {
        return dayjs(date).tz(dayjs.tz.guess()).format('MMMM DD, YYYY');
    }

    return { formatDateFromString };
}
