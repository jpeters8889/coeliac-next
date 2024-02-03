// @ts-ignore
import emitter from 'tiny-emitter/instance';

export default {
  $on: (event: string, ...args: any) => emitter.on(event, ...args),
  $once: (event: string, ...args: any) => emitter.once(event, ...args),
  $off: (event: string, ...args: any) => emitter.off(event, ...args),
  $emit: (event: string, ...args: any) => emitter.emit(event, ...args),
};
