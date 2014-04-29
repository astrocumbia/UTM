#ifndef _POINT_H_
#define _POINT_H_

#include <iostream>

class Point{
	private:	
		double x, y;
	
	public:
		Point( double , double  );
		Point( );
		Point( int , int  );
		int getXd( );
		double getXf( );
		int getYd( );
		double getYf( );
		void setX( int );
		void setX( double );
		void setY( int );
		void setY( double );
		void set( double , double );
		void set( int , int );
		void print( );
		void println( );
};


#endif