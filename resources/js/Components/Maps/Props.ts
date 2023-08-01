export type MapProps = {
  lat: number;
  lng: number;
  zoom?: number;
};

export const MapPropDefaults: Partial<MapProps> = {
  zoom: 16,
};
