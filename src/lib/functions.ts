declare var window: any;

type JsVars = {
  isGuest: boolean;
  loginUrl: string;
};

export const jsVars = (): JsVars => window.jsVars;

export const isGuest = (): boolean => jsVars().isGuest;

export const isAuth = (): boolean => !isGuest();

export const loginUrl = (): string => jsVars().loginUrl;
