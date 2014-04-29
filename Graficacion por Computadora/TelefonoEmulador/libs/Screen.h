#ifndef _SCREEN_H_
#define _SCREEN_H_

#include <SDL/SDL.h>
#include <SDL/SDL_image.h>
#include <SDL/SDL_ttf.h>
#include <iostream>
#include "Point.cpp"


class Screen{
	
	private:
		SDL_Surface *screen;
		SDL_Surface *icon;
		SDL_Surface *transparencia;
		SDL_Surface *imgs[10];
		char *name, *icon_path;
		int width , height  ;
		TTF_Font *fonts[10];
		SDL_Color MYCOLOR;
		SDL_Rect  RECT_LETRAS;
		SDL_Surface *SURFACE_LETRAS;
		
		void Bresenham( int, int, int, int, int);
	public:
		Screen( );
		Screen( int, int );
		Screen(int, int, char *);
		Screen(int, int, char *, char *);
		int getWidth(  );
		void setWidth( int );
		int getHeight( );
		void setHeight( int );

		void init_SDL( );
		void close_SDL( );
		void update( );

		void putpixel( int x, int y , int color );
		void putpixel( int x, int y, int r, int g, int b );
		void putpixel( Point , int );
		void putpixel( Point, int, int, int );
		void drawLine( int, int, int, int, int );
		void drawLine( Point a, Point b, int);

		void clear( );
		void putTransparencia( int , int );
		void putTransparencia( Point );

		void init_myfonts( );
		void load_font( TTF_Font **ptr, char *name, int size );
		void print( char *c, int x, int y, int r, int g, int b, int indexFont);

		void drawIcon( int, int , int );
};
#endif