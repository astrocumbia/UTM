#ifndef _POLYGON2D_CPP_
#define _POLYGON2D_CPP_

#include "Polygon2D.h"

Polygon2D::Polygon2D( ){
	vertex.clear( );
	flag = false;
	matrix.identity( );
}

void Polygon2D::clear( ){
	vertex.clear( );
	matrix.identity( );
	flag = false;
}

void Polygon2D::create( ){
	clear( );
	matrix.identity( );
}

void Polygon2D::pushVertex( int x, int y ){
	if( isClose() ){
		vertex[ vertex.size()-1 ] = Point(x,y);
		vertex.push_back( vertex[0] );
	}
	else
		vertex.push_back( Point( x, y ) );
}

void Polygon2D::pushVertex( double x, double y ){
	if( isClose() ){
		vertex[ vertex.size()-1 ] = Point(x,y);
		vertex.push_back( vertex[0] );
	}
	else
		vertex.push_back( Point( x, y ) );
}

void Polygon2D::pushVertex( Point a ){
	if( isClose() ){
		vertex[ vertex.size()-1 ] = a;
		vertex.push_back( vertex[0] );
	}
	else
		vertex.push_back( a );
}

void Polygon2D::close( ){
	vertex.push_back( vertex[0] );
	flag = true;
}

bool Polygon2D::isClose( ){
	return flag;
}

int Polygon2D::getSize( ){
	return vertex.size( );
}

Point Polygon2D::getVertex( int index ){
	if( index >= getSize( ) )
		return Point(0,0);
	return vertex[ index ];
}

void Polygon2D::drawPolygonOriginal( Screen screen , int COLOR){
	for( int i=0; i < vertex.size()-1; i++ ){
		screen.drawLine( vertex[ i ], vertex[ i+1 ], COLOR );
	}
}


void Polygon2D::drawPolygon( Screen screen, int COLOR ){
	std::vector< Point > aux;
     
     for( int i=0; i< vertex.size(); i++ ){
          double tmp[3] ={ vertex[i].getXf(), vertex[i].getYf(), 1.0};
          double X = (tmp[0]*matrix.getIndexOf(0,0))+(matrix.getIndexOf(0,1)*tmp[1])+(matrix.getIndexOf(0,2)*tmp[2]);
          double Y = (tmp[0]*matrix.getIndexOf(1,0))+(matrix.getIndexOf(1,1)*tmp[1])+(matrix.getIndexOf(1,2)*tmp[2]); 
          aux.push_back( Point( X, Y) );
     }
     for( int i=0; i< aux.size()-1; i++ )
     	screen.drawLine( aux[i], aux[i+1], COLOR );
}

bool Polygon2D::between( int Ysup, int Yinf, int Y )
{
     if( Y>=Yinf && Y<Ysup )
         return true;
     return false;   
}

int Polygon2D::interseccionX( Point a, Point b, int y )
{
    double delta = (b.getXf() - a.getXf());
    double divi = (b.getYf() - a.getYf()) != 0 ? (b.getYf() - a.getYf()): 1; 
    delta/=divi;
    double diff = (double)y-a.getYf();
    double interseccion = (diff*delta)+(double)a.getXf();
    return (int)interseccion;
}

void Polygon2D::__fillPolygon( std::vector < Point > POLYGON, Screen screen, int COLOR ){
     int hMAX = screen.getHeight( );
     int wMAX = screen.getWidth( );
     
     for( int Ybarrido=0; Ybarrido<hMAX; Ybarrido++)/*Iterar sobre la pantalla*/
     {

           std::vector < int > intersecciones;
           for( int index = 0; index <POLYGON.size()-1; index++ )/*Iterar sobre puntos del poligono*/
           {
                if( between( std::max(POLYGON[index].getYd(), POLYGON[index+1].getYd()), std::min(POLYGON[index].getYd(),POLYGON[index+1].getYd()), Ybarrido ) ) /*Existe Interseccion*/
                    intersecciones.push_back( interseccionX( POLYGON[index], POLYGON[index+1], Ybarrido ) );/*GuardarInterseccion*/
           }
		  sort( intersecciones.begin(), intersecciones.end() );
           /* Hacer barrido de las intersecciones en x */
           for( int index = 0; index < intersecciones.size(); index+=2){
               int Xinicio = intersecciones[ index ];
               int Xfin    = intersecciones[ index+1 ];
               for( int Xbarrido = Xinicio; Xbarrido < Xfin && Xbarrido >= 0 && Xfin>=0; Xbarrido++ ){
                     screen.putpixel( Xbarrido, Ybarrido, COLOR );        
                     
                }       

           }
     }
}

void Polygon2D::fillPolygon( Screen screen, int COLOR ){
	std::vector< Point > aux;
     
     for( int i=0; i< vertex.size(); i++ ){
          double tmp[3] ={ vertex[i].getXf(), vertex[i].getYf(), 1.0};
          double X = (tmp[0]*matrix.getIndexOf(0,0))+(matrix.getIndexOf(0,1)*tmp[1])+(matrix.getIndexOf(0,2)*tmp[2]);
          double Y = (tmp[0]*matrix.getIndexOf(1,0))+(matrix.getIndexOf(1,1)*tmp[1])+(matrix.getIndexOf(1,2)*tmp[2]); 
          aux.push_back( Point( X, Y) );
     }
     __fillPolygon( aux, screen, COLOR );

}

void Polygon2D::createCircle(int xc, int yc, int r ){
    create( );
    for( int i=0; i<=90; i++ ){
        double x = (double)xc + r*cos((i*4*_PI)/180);
        double y = (double)yc + r*sin((i*4*_PI)/180);
        pushVertex( x, y );
    }
    close( );
}
#endif