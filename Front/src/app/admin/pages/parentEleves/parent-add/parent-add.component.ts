import { Component, OnDestroy, OnInit } from '@angular/core';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { ParentElevesService } from '../service/parent-eleves.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-parent-add',
  templateUrl: './parent-add.component.html',
  styleUrls: ['./parent-add.component.css']
})
export class ParentAddComponent implements OnInit,OnDestroy{
  public ImageOneUpload:any;
  public imgUpload:string="";
  public defaultImg:string="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1361&q=80";
  public formParent= new FormGroup({
    prenom: new FormControl('',Validators.required),
    nom: new FormControl('',Validators.required),
    telephone: new FormControl(''),
    email: new FormControl(''),
    adresse: new FormControl('',Validators.required),
    profession: new FormControl('',Validators.required),
    sex: new FormControl('',Validators.required),
    commentaire: new FormControl(''),

  });
  constructor(private parentService:ParentElevesService,private router:Router){}
  ngOnInit(): void {
    this.imgUpload=this.defaultImg;
  }
  ngOnDestroy(): void {
    
  }
  handleOneFileInput(event:any){
    const fileList:FileList = event.target.files;
    this.ImageOneUpload=[];
    for (let index = 0; index < fileList.length; index++) {
      this.ImageOneUpload.push(fileList.item(index));
      const file = fileList[index];
      const fileType = file.type.split('/')[0];
      const fileUrl = URL.createObjectURL(file);
      this.imgUpload=fileUrl;
    }
  }
  submitParent(){
    console.log(this.formParent);
    const formData:FormData = new FormData();
    let isUploadImg="false"
    if (this.imgUpload!=this.defaultImg) {
      formData.append("image",this.ImageOneUpload[0], this.ImageOneUpload[0].name);
      isUploadImg="true";
    }
    formData.append("isUpload",isUploadImg);
    formData.append("prenom",this.formParent.get('prenom')?.value ?? "");
    formData.append("nom",this.formParent.get('nom')?.value ?? "");
    formData.append("telephone",this.formParent.get('telephone')?.value ?? "");
    formData.append("email",this.formParent.get('email')?.value ?? "");
    formData.append("adresse",this.formParent.get('adresse')?.value ?? "");
    formData.append("profession",this.formParent.get('profession')?.value ?? "");
    formData.append("sex",this.formParent.get('sex')?.value ?? "");
    formData.append("commentaire",this.formParent.get('commentaire')?.value ?? "");
    this.parentService.saveParentEleves(formData).subscribe(
      res=>{
        console.log("Perfec");
        console.log(res);
        this.router.navigateByUrl("/admin/parent")
      },
      error=>{
        console.log("Error");
        console.log(error);
        
      }
    )
  }
}
