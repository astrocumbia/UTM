#ifndef _SCREEN_CPP_
#define _SCREEN_CPP_

#include "Screen.h"

/**********************
*   FUNCIONES ACCESO  *
**********************/

Screen::Screen( ){
	setWidth( 100 );
	setHeight( 100 );
	icon      = NULL;
	screen    = NULL;
	icon_path = NULL;
}

Screen::Screen( int w, int h ){
	setWidth( w );
	setHeight( h );
	icon      = NULL;
	screen    = NULL;
	icon_path = NULL;	
}

Screen::Screen( int w, int h, char *name ){
	setWidth( w );
	setHeight( h );
	this->name = name;
	icon_path    = NULL;
	screen       = NULL;
}

Screen::Screen( int w, int h, char *name, char *icon ){
	setWidth( w );
	setHeight( h );
	this->name      = name;
	this->icon_path = icon;
	screen          = NULL;
}

int Screen::getWidth( ){
	return this->width;
}

void Screen::setWidth( int w ){
	this-> width = w > 100 ? w:100;
}

void Screen::setHeight( int h ){
	this->height = h > 100? h:100;
}

int Screen::getHeight( ){
	return this->height;
}

/*******************************
* CREACION DE VENTANA          *
*******************************/

void Screen::init_SDL( ){

	if (SDL_Init (SDL_INIT_VIDEO) < 0)
    {
    	std::cout<<" Error al inciar video \n";
        exit (1);
    }
    screen = SDL_SetVideoMode ( (int)width, (int)height, 32, SDL_SWSURFACE | SDL_DOUBLEBUF);
    if ( screen == NULL)
    {
       std::cout<<" Error al iniciar video\n";
       exit( 2 );
    }
    TTF_Init();
    SDL_WM_SetCaption ( (char*)name , NULL );
    SDL_WM_SetIcon( SDL_LoadBMP( (char*)icon_path), NULL );
    init_myfonts( );
    transparencia = IMG_Load("files/img/trans.png");
    
    imgs[ 0 ] = IMG_Load("files/img/app0.png");
    imgs[ 1 ] = IMG_Load("files/img/app1.png");
    imgs[ 2 ] = IMG_Load("files/img/app2.png");
    imgs[ 3 ] = IMG_Load("files/img/app3.png");
    imgs[ 4 ] = IMG_Load("files/img/teclado.png");
}

void Screen::close_SDL( ){
	SDL_FreeSurface( screen );
	SDL_FreeSurface( icon );
	SDL_FreeSurface( transparencia );
	SDL_FreeSurface( SURFACE_LETRAS );
	for( int i=0; i<10; i++ )
		SDL_FreeSurface( imgs[i] );

	SDL_Quit( );
}

/*******************************
*  Manejo de Graficos simples  *
*  sobre la pantalla           *
********************************/

void Screen::update( ){
	SDL_Flip (screen);
}

void Screen::putpixel( int x, int y , int color ){
    if( x >= 0 && x < screen->w && y >= 0 && y < screen->h ){
        	unsigned int *ptr = (unsigned int*)screen->pixels;
        	int lineoffset = (screen->h-1-y) * (screen->pitch / 4);
        	ptr[lineoffset + x] = color;
    }	
}

void Screen::putpixel( int x, int y, int r, int g, int b ){
    int color = (int)SDL_MapRGB(screen->format,r,g,b); 
    if( x >= 0 && x < screen->w && y >= 0 && y < screen->h ){
        	unsigned int *ptr = (unsigned int*)screen->pixels;
        	int lineoffset = (screen->h-1-y) * (screen->pitch / 4);
        	ptr[lineoffset + x] = color;
    }   	
}

void Screen::putpixel( Point p, int color ){
	int x = p.getXd( );
	int y = p.getYd( );
	if( x >= 0 && x < screen->w && y >= 0 && y < screen->h ){
       	unsigned int *ptr = (unsigned int*)screen->pixels;
       	int lineoffset = (screen->h-1-y) * (screen->pitch / 4);
       	ptr[lineoffset + x] = color;
    }	
}

void Screen::putpixel( Point p, int r, int g, int b ){
	int x     = p.getXd( );
	int y     = p.getYd( );
	int color = (int)SDL_MapRGB(screen->format,r,g,b); 

    if( x >= 0 && x < screen->w && y >= 0 && y < screen->h ){
        	unsigned int *ptr = (unsigned int*)screen->pixels;
        	int lineoffset = (screen->h-1-y) * (screen->pitch / 4);
        	ptr[lineoffset + x] = color;
    }   	
}

void Screen::drawLine( int x0, int y0, int x1, int y1, int COLOR ){
	Bresenham( x0, y0, x1, y1, COLOR );
}

void Screen::drawLine( Point a, Point b, int COLOR ){
	Bresenham( a.getXd(), a.getYd(), b.getXd(), b.getYd(), COLOR );
}

void Screen::Bresenham( int x0, int y0, int x1, int y1, int COLOR )
{
	int dx = abs( x1-x0 );
	int dy = abs( y1-y0 );	
	int sy, sx, err=dx-dy, e2;
	
	if( x0 < x1 )		sx = 1;
	else				sx = -1;
	if( y0 < y1 ) 		sy = 1;
	else 				sy = -1;
	
	while( true ){
		if( x0 >= 0 && x0 < getWidth() && y0>=0 && y0< getHeight() ) 
			putpixel( x0, y0, COLOR );
		if( x0 == x1 && y0 == y1 ) 
			break;
		
		e2 = 2*err;
		
		if( e2 > -dy ){
			err = err - dy;
			x0 = x0 + sx;	
		}
		if( x0 == x1 && y0 == y1 ){
			if( x0 >= 0 && x0 < getWidth() && y0>=0 && y0< getHeight() ) 
				putpixel( x0, y0 , COLOR );
			break;	
		}
		if( e2 < dx ){
			err = err + dx;
			y0 = y0 + sy;
		}
	}	
}

void Screen::clear( ){
	for( int i=0; i<screen->w; i++ )
		for( int j=0; j<screen->h; j++ )
			putpixel( i, j, 0x000000 );
}

void Screen::putTransparencia( int x, int y ){
	SDL_Rect pos;
	pos.x = x;
	pos.y = screen->h-1-y;
	SDL_BlitSurface(transparencia,NULL,screen,&pos);		
}

void Screen::putTransparencia( Point p ){
	SDL_Rect pos;
	pos.x = p.getXd( );
	pos.y = p.getYd( );
	SDL_BlitSurface(transparencia,NULL,screen,&pos);		
}

/*************************
*  FUNCIONES CON LETRAS  *
*************************/

void Screen::init_myfonts( ){
     load_font( &fonts[0], "files/font/Roboto-Bold.ttf", 20 );//USADA
     load_font( &fonts[1], "files/font/Roboto-Condensed.ttf", 30 );//usada
     load_font( &fonts[2], "files/font/Roboto-Light.ttf", 35 );//usada
     load_font( &fonts[3], "files/font/Roboto-Medium.ttf", 60 );//usada
     load_font( &fonts[4], "files/font/Roboto-Regular.ttf", 150 );//usada
     load_font( &fonts[5], "files/font/Ubuntu-L.ttf", 27 );//USADA
     load_font( &fonts[6], "files/font/Ubuntu-R.ttf", 21 );//USADA
     load_font( &fonts[7], "files/font/Roboto-Light.ttf", 60 );//usada
	 load_font( &fonts[8], "files/font/Roboto-Bold.ttf", 90 );//USADA
	 load_font( &fonts[9], "files/font/Ubuntu-L.ttf", 75 );//USADA
}

void Screen::load_font( TTF_Font **ptr, char *name, int size ){
	*ptr = TTF_OpenFont( name , size );
    if( *ptr == NULL ) exit(1);
}

void Screen::print( char *c, int x, int y, int r, int g, int b, int indexFont ){
     MYCOLOR.r = r;
     MYCOLOR.g = g;
     MYCOLOR.b = b;
     RECT_LETRAS.x = x;
     RECT_LETRAS.y = screen->h-1-y;
     SURFACE_LETRAS = TTF_RenderText_Solid( fonts[indexFont], c, MYCOLOR );
     SDL_BlitSurface( SURFACE_LETRAS, NULL, screen, &RECT_LETRAS );
     
}

void Screen::drawIcon( int x, int y, int index ){
	SDL_Rect pos ={ x, y, 0, 0};
	SDL_BlitSurface( imgs[ index ], NULL, screen, &pos );
}


#endif 