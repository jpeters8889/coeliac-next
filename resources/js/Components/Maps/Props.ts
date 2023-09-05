export type MapProps = {
  lat: number;
  lng: number;
  zoom?: number;
};

export const MapPropDefaults: Partial<MapProps> = {
  zoom: 16,
};

export type MapModalProps = MapProps & {
  title?: string;
};

export const MapModalPropDefaults = {
  ...MapPropDefaults,
  title: undefined,
};
