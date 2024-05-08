import mitt from 'mitt';

const emitter = mitt();

export default {
  $on: (event: string, handler: () => void) => emitter.on(event, handler),
  $emit: (event: string) => emitter.emit(event),
};
