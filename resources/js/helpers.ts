import dayjs from 'dayjs';
import advancedFormat from 'dayjs/plugin/advancedFormat';

export const formatDate = (date: string, format: string = 'Do MMM YYYY'): string => {
  dayjs.extend(advancedFormat);

  return dayjs(date).format(format);
};
